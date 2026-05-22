<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$json_data = file_get_contents('data/products.json');
$products = json_decode($json_data, true);

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

function parse_price($price)
{
    return floatval(str_replace(['€', ' ', ','], ['', '', '.'], $price));
}

$totalAmount = 0;
foreach ($cart as $item) {
    $totalAmount += parse_price($item['price']) * $item['quantity'];
}

$orderSuccess = false;
$errors = []; // Mảng chứa các lỗi validation

// Khởi tạo biến để giữ lại dữ liệu cũ khi form bị lỗi
$fullName = '';
$email = '';
$phone = '';
$address = '';
$paymentMethod = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    // 1. Validate Họ và tên
    if (empty($fullName)) {
        $errors['full_name'] = 'Please enter your full name.';
    } elseif (strlen($fullName) < 2) {
        $errors['full_name'] = 'Name must be at least 2 characters long.';
    }

    // 2. Validate Email
    if (empty($email)) {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address format.';
    }

    // 3. Validate Số điện thoại (Ví dụ quy chuẩn cho số từ 9 - 11 chữ số)
    if (empty($phone)) {
        $errors['phone'] = 'Please enter your phone number.';
    } elseif (!preg_match('/^[0-9]{9,11}$/', str_replace([' ', '-', '+'], '', $phone))) {
        $errors['phone'] = 'Phone number must be between 9 and 11 digits.';
    }

    // 4. Validate Địa chỉ
    if (empty($address)) {
        $errors['address'] = 'Please enter your shipping address.';
    } elseif (strlen($address) < 10) {
        $errors['address'] = 'Please provide a more detailed address.';
    }

    // 5. Validate Phương thức thanh toán 
    $allowed_methods = ['cash', 'bank_transfer'];
    if (empty($paymentMethod)) {
        $errors['payment_method'] = 'Please select a payment method.';
    } elseif (!in_array($paymentMethod, $allowed_methods)) {
        $errors['payment_method'] = 'Invalid payment method selected.';
    }

    // Nếu không có lỗi nào thì tiến hành đặt hàng
    if (empty($errors)) {
        $orderSuccess = true;
        $_SESSION['last_order'] = [
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'payment_method' => $paymentMethod,
            'total' => $totalAmount,
            'items' => $cart,
        ];
        $_SESSION['cart'] = [];
        $cart = [];
    }
}

include 'components/header.php';
include 'components/navbar.php';
?>

<div class="checkout-page">
    <?php if ($orderSuccess): ?>
        <div class="checkout-success">
            <div class="success-icon">✓</div>
            <h1>Order Placed Successfully!</h1>
            <p class="success-message">Thank you for your purchase. Your order has been confirmed.</p>
            <div class="order-info">
                <p><strong>Customer:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['full_name']); ?></p>
                <p><strong>Order Total:</strong> €<?php echo number_format($totalAmount, 2); ?></p>
                <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace('_', ' ', $_SESSION['last_order']['payment_method'])); ?></p>
                <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($_SESSION['last_order']['address']); ?></p>
            </div>
            <a href="shop.php" class="btn-success">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="checkout-grid">
            <div class="checkout-form-section">
                <h1>Billing Information</h1>
                <form method="post" class="checkout-form">
                    
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($fullName); ?>">
                        <?php if (isset($errors['full_name'])): ?>
                            <span class="error-msg" style="color: red; font-size: 14px;"><?php echo $errors['full_name']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <span class="error-msg" style="color: red; font-size: 14px;"><?php echo $errors['email']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <span class="error-msg" style="color: red; font-size: 14px;"><?php echo $errors['phone']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="address">Shipping Address *</label>
                        <textarea id="address" name="address" rows="4"><?php echo htmlspecialchars($address); ?></textarea>
                        <?php if (isset($errors['address'])): ?>
                            <span class="error-msg" style="color: red; font-size: 14px;"><?php echo $errors['address']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method *</label>
                        <select id="payment_method" name="payment_method">
                            <option value="">Select a payment method</option>
                            <option value="cash" <?php echo $paymentMethod === 'cash' ? 'selected' : ''; ?>>Cash</option>
                            <option value="bank_transfer" <?php echo $paymentMethod === 'bank_transfer' ? 'selected' : ''; ?>>Bank Transfer</option>
                        </select>
                        <?php if (isset($errors['payment_method'])): ?>
                            <span class="error-msg" style="color: red; font-size: 14px;"><?php echo $errors['payment_method']; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Complete Order</button>
                        <a href="cart.php" class="btn-cancel">Back to Cart</a>
                    </div>
                </form>
            </div>

            <div class="order-summary-section">
                <h2>Order Summary</h2>
                <div class="order-items">
                    <?php foreach ($cart as $item): ?>
                        <div class="order-item">
                            <div class="item-info">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-thumbnail">
                                <div class="item-details">
                                    <p class="item-name"><?php echo htmlspecialchars($item['name']); ?></p>
                                    <p class="item-qty">Qty: <?php echo intval($item['quantity']); ?></p>
                                </div>
                            </div>
                            <p class="item-price"><?php echo htmlspecialchars($item['price']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="order-total">
                    <p><strong>Total Items:</strong> <?php echo array_sum(array_column($cart, 'quantity')); ?></p>
                    <p class="final-total"><strong>Total Amount:</strong> <span>€<?php echo number_format($totalAmount, 2); ?></span></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'components/footer.php'; ?>