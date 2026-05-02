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
                    <button class="add-to-cart">Add to Cart</button>
                </div>
            </div>
        <?php else: ?>
            <div class="product-missing">
                <h2>Product not found</h2>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'components/footer.php'; ?>