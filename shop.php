<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>

<?php
$json_data = file_get_contents('data/products.json');
$products = json_decode($json_data, true);
?>

<div class="category-header">
    <h2 class="chosen-title active">ANIMALS</h2>
</div>
<section class="products">
    <?php foreach ($products as $product): ?>
        <?php
        if ($product['category'] === 'animals'):
        ?>
            <div class="product-card">
                <!-- Link tới trang chi tiết -->
                <a href="product_details.php?id=<?php echo $product['id']; ?>">
                    <!-- Ảnh -->
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </a>

                <!-- Tên -->
                <h3 class="name"><?php echo $product['name']; ?></h3>

                <!-- Giá -->
                <span class="price"><?php echo $product['price']; ?></span>

            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</section>

<div class="category-header">
    <h2 class="chosen-title active">FOOD</h2>
</div>
<section class="products">
    <?php foreach ($products as $product): ?>
        <?php if ($product['category'] === 'food'): ?>
            <div class="product-card">
                <a href="product_details.php?id=<?php echo $product['id']; ?>">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </a>
                <h3 class="name"><?php echo $product['name']; ?></h3>
                <span class="price"><?php echo $product['price']; ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</section>

<div class="category-header">
    <h2 class="chosen-title active">OCEAN</h2>
</div>
<section class="products">
    <?php foreach ($products as $product): ?>
        <?php if ($product['category'] === 'ocean'): ?>
            <div class="product-card">
                <a href="product_details.php?id=<?php echo $product['id']; ?>">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </a>
                <h3 class="name"><?php echo $product['name']; ?></h3>
                <span class="price"><?php echo $product['price']; ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</section>

<?php include 'components/footer.php'; ?>