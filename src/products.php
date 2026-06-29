<?php
require_once 'config/database.php';
include 'includes/header.php';

$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$conn = getDBConnection();

// Get brand banner
$banner_result = $conn->query("SELECT banner FROM products WHERE brand = '$brand' LIMIT 1");
$banner = $banner_result->fetch_assoc();
?>
<div class="products-page">
    <?php if($brand): ?>
        <div class="brand-banner">
            <?php if($banner && $banner['banner']): ?>
                <img src="/assets/images/banners/<?php echo $banner['banner']; ?>" alt="<?php echo $brand; ?> Banner" />
            <?php endif; ?>
            <h1><?php echo $brand; ?> Collection</h1>
        </div>
    <?php endif; ?>

    <div class="products-grid">
        <?php
        $query = "SELECT * FROM products";
        if($brand) {
            $query .= " WHERE brand = '$brand'";
        }
        $query .= " ORDER BY price ASC";
        $result = $conn->query($query);
        
        while($product = $result->fetch_assoc()):
        ?>
            <div class="product-card">
                <img src="/assets/images/watches/<?php echo $product['image']; ?>" alt="<?php echo $product['model']; ?>" />
                <h4><?php echo $product['model']; ?></h4>
                <p class="brand-name"><?php echo $product['brand']; ?></p>
                <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                <p class="gender"><?php echo $product['gender']; ?></p>
                <p class="description"><?php echo $product['description']; ?></p>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="/add-to-cart.php?product_id=<?php echo $product['id']; ?>" class="btn-add-cart">Add to Cart</a>
                <?php else: ?>
                    <a href="/login.php" class="btn-add-cart">Login to Add</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
