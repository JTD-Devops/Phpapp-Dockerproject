<?php
require_once 'config/database.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = getDBConnection();

// Get cart items
$query = "
    SELECT c.id as cart_id, p.*, c.quantity 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = $user_id
";
$result = $conn->query($query);

$total = 0;
?>
<div class="cart-page">
    <h1>Shopping Cart</h1>
    
    <?php if($result->num_rows > 0): ?>
        <div class="cart-items">
            <?php while($item = $result->fetch_assoc()): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <div class="cart-item">
                    <img src="/assets/images/watches/<?php echo $item['image']; ?>" alt="<?php echo $item['model']; ?>" />
                    <div class="item-details">
                        <h3><?php echo $item['model']; ?></h3>
                        <p class="brand"><?php echo $item['brand']; ?></p>
                        <p class="gender"><?php echo $item['gender']; ?></p>
                        <p class="price">₹<?php echo number_format($item['price'], 2); ?> each</p>
                        <div class="quantity-control">
                            <span>Quantity: <?php echo $item['quantity']; ?></span>
                        </div>
                        <p class="subtotal">Subtotal: ₹<?php echo number_format($subtotal, 2); ?></p>
                        <a href="/remove-from-cart.php?cart_id=<?php echo $item['cart_id']; ?>" class="btn-remove">Remove</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <div class="cart-summary">
            <h2>Order Summary</h2>
            <div class="summary-row">
                <span>Total Items:</span>
                <span><?php echo $result->num_rows; ?></span>
            </div>
            <div class="summary-row">
                <span>Total Amount:</span>
                <span class="total-amount">₹<?php echo number_format($total, 2); ?></span>
            </div>
            <button class="btn-checkout" onclick="alert('Checkout functionality coming soon!')">Proceed to Checkout</button>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <a href="/index.php" class="btn-primary">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
