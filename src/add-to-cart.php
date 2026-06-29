<?php
require_once 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

if (isset($_GET['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    
    $conn = getDBConnection();
    
    // Check if product already in cart
    $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Update quantity
        $new_quantity = $row['quantity'] + 1;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_quantity, $row['id']);
        $stmt->execute();
    } else {
        // Add new item
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }
    
    header('Location: /cart.php');
} else {
    header('Location: /index.php');
}
exit();
?>
