<?php include 'components/header.php'; ?>
<?php include 'components/navbar.php'; ?>

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

<?php include 'components/footer.php'; ?>
</body>
</html>