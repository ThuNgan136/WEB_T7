<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>MIMI TEDDY</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- icon font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- font chữ -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="logo">
            <a href="/">🐻 MIMI TEDDY</a>
        </div>

        <div class="icons">
            <a href="login.php" class="icon-link">
                <i class="fas fa-user"></i>
            </a>
            
            <a href="cart.php" class="icon-link">
                <i class="fas fa-shopping-cart"></i>
            </a>
        </div>
    </header>