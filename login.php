<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIMI TEDDY</title>
</head>
<body>
    <?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<section class="login-page">
    <div class="login-box">
        <h2>Welcome Back</h2>
        <p>Please login to your account 🧸</p>

        <form>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>

            <button type="submit">LOGIN</button>
        </form>

        <p class="extra">
            Don't have an account? <a href="/register.php">Register</a>
        </p>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>