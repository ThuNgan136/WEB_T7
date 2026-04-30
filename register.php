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
        <h2>Create Account</h2>
        <p>Join MIMI TEDDY today 🧸</p>

        <form>
            <input type="text" placeholder="Full Name" required>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <input type="password" placeholder="Confirm Password" required>

            <button type="submit">REGISTER</button>
        </form>

        <p class="extra">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>