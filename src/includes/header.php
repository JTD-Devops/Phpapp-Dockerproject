<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WatchStore - Premium Watches</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">⌚ WatchStore</div>
            <nav class="nav-links">
                <a href="/index.php">Home</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span style="color: #d4af37;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="/logout.php">Logout</a>
                    <a href="/cart.php" class="btn-cart">🛒 Cart</a>
                <?php else: ?>
                    <a href="/login.php">Login</a>
                    <a href="/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </header>
