<?php 
include 'components/header.php';
include 'components/navbar.php';

// 1. Lấy ID từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. Đọc file JSON
$json_data = file_get_contents('data/products.json');
$products = json_decode($json_data, true);

// 3. Tìm sản phẩm có ID khớp
$current_product = null;
foreach ($products as $p) {
    if ($p['id'] === $id) {
        $current_product = $p;
        break;
    }
}
?>


    <div class="product-detail-container">
        <a href="shop.php" class="btn-back">← BACK</a>

        <?php if ($current_product): ?>
            <div class="detail-grid">
                <div class="image-section">
                    <img src="<?php echo $current_product['image']; ?>" alt="<?php echo $current_product['name']; ?>">
                </div>
                <div class="info-section">
                    <h1 class="name"><?php echo $current_product['name']; ?></h1>
                    <p class="price"><?php echo $current_product['price']; ?></p>
                    <p class="description"><?php echo $current_product['description']; ?></p>
                    <form action="cart.php" method="post" class="add-to-cart-form">
                        <div class="quantity-input">
                            <button type="button" class="quantity-button" id="decrease-btn">−</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1">
                            <button type="button" class="quantity-button" id="increase-btn">+</button>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $current_product['id']; ?>">
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="product-missing">
                <h2>Product not found</h2>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    const quantityInput = document.getElementById('quantity');
    const increaseBtn = document.getElementById('increase-btn');
    const decreaseBtn = document.getElementById('decrease-btn');

    if (quantityInput && increaseBtn && decreaseBtn) {
        increaseBtn.addEventListener('click', () => {
            quantityInput.value = parseInt(quantityInput.value, 10) + 1;
        });

        decreaseBtn.addEventListener('click', () => {
            const currentValue = parseInt(quantityInput.value, 10);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    }
</script>

<?php include 'components/footer.php'; ?>