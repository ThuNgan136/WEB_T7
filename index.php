<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>

<?php
$allowed_ids = [5, 7, 1, 11, 6];
$json_data = file_get_contents('data/products.json');
$products = json_decode($json_data, true);
?>

<!-- BANNER -->
<section class="banner">
    <div class="banner-left">
        <h1>Made for hugs...</h1>
        <p>
            Meet our adorable plush friends — soft, cuddly, and full of charm. <br>
            Perfect for gifts or your everyday snuggles.
        </p>
        <a href="/shop.php" class="btn">SHOP NOW</a>
    </div>

    <div class="banner-right">
        <img src="images/banner.png" alt="banner">
    </div>
</section>

<section class="chosen-section">
    <h1 class="chosen-title">CHOSEN FOR YOU</h1>
    <section class="products">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php
                if (in_array($product['id'], $allowed_ids)):
                ?>
                    <div class="product-card">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </a>
                        <h3 class="name"><?php echo $product['name']; ?></h3>
                        <span class="price"><?php echo $product['price']; ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</section>

<div class="about-banner">
    <img src="images/about/about3.jpg" alt="about3">
    <h2>Collect Jellies. Earn Purrks Points. Unlock Rewards</h2>
</div>

<?php include 'components/footer.php'; ?>
</body>