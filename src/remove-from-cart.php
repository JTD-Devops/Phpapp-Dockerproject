<?php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $user_id = $_SESSION['user_id'];
    
    $conn = getDBConnection();
    
    // Verify cart item belongs to user
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
}

header('Location: /cart.php');
exit();
?>
