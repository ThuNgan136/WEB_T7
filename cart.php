<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$json_data = file_get_contents('data/products.json');
$products = json_decode($json_data, true);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = &$_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];
    $action = isset($_POST['action']) ? $_POST['action'] : 'add';
    $productToAdd = null;

    foreach ($products as $product) {
        if ($product['id'] === $product_id) {
            $productToAdd = $product;
            break;
        }
    }

    if ($productToAdd) {
        if ($action === 'increase') {
            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] += 1;
            } else {
                $cart[$product_id] = [
                    'id' => $productToAdd['id'],
                    'name' => $productToAdd['name'],
                    'price' => $productToAdd['price'],
                    'image' => $productToAdd['image'],
                    'quantity' => 1,
                ];
            }
        } elseif ($action === 'decrease') {
            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] -= 1;
                if ($cart[$product_id]['quantity'] <= 0) {
                    unset($cart[$product_id]);
                }
            }
        } else {
            $quantity = isset($_POST['quantity']) ? max(1, (int) $_POST['quantity']) : 1;

            if (isset($cart[$product_id])) {
                $cart[$product_id]['quantity'] += $quantity;
            } else {
                $cart[$product_id] = [
                    'id' => $productToAdd['id'],
                    'name' => $productToAdd['name'],
                    'price' => $productToAdd['price'],
                    'image' => $productToAdd['image'],
                    'quantity' => $quantity,
                ];
            }
        }
    }

    header('Location: cart.php');
    exit;
}

function format_price($price)
{
    return $price;
}

function parse_price($price)
{
    return floatval(str_replace(['€', ' ', ','], ['', '', '.'], $price));
}

$totalAmount = 0;
foreach ($cart as $item) {
    $totalAmount += parse_price($item['price']) * $item['quantity'];
}

include 'components/header.php';
include 'components/navbar.php';
?>

<div class="cart-page">
    <div class="cart-content">
        <div class="cart-header">
            <div>
                <h1>Your Shopping Cart</h1>
                <p class="cart-meta"><?php echo count($cart); ?> products, <?php echo array_sum(array_column($cart, 'quantity')); ?> items</p>
            </div>
            <div class="cart-actions">
                <a href="shop.php" class="cart-continue">Continue Shopping</a>
                <?php if (!empty($cart)): ?>
                    <a href="checkout.php" class="cart-checkout">Checkout</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (empty($cart)): ?>
            <div class="cart-empty">
                <p>Your cart is currently empty.</p>
                <a href="shop.php">Explore Products</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td data-label="Image"><img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-thumbnail"></td>
                            <td data-label="Product Name"><?php echo $item['name']; ?></td>
                            <td data-label="Price"><?php echo format_price($item['price']); ?></td>
                            <td data-label="Quantity">
                                <div class="quantity-control">
                                    <form action="cart.php" method="post" class="quantity-form">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="quantity-btn">−</button>
                                    </form>
                                    <span class="quantity-value"><?php echo $item['quantity']; ?></span>
                                    <form action="cart.php" method="post" class="quantity-form">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="quantity-btn">+</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <p>Total items: <strong><?php echo array_sum(array_column($cart, 'quantity')); ?></strong></p>
                <p class="cart-total">Total amount: <strong>€<?php echo number_format($totalAmount, 2); ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'components/footer.php'; ?>