<?php
require_once 'config/database.php';
include 'includes/header.php';

$conn = getDBConnection();
$brands = ['Titan', 'Casio', 'Sonata', 'Rolex'];
?>
<main>
    <div class="hero-section">
        <h1>Discover Premium Timepieces</h1>
        <p>Explore our collection of luxury watches from world-renowned brands</p>
    </div>

    <section class="brand-grid">
        <?php foreach($brands as $brand): ?>
            <a href="/products.php?brand=<?php echo urlencode($brand); ?>" class="brand-card">
                <h3><?php echo $brand; ?></h3>
                <p>Explore Collection</p>
            </a>
        <?php endforeach; ?>
    </section>

    <section class="featured-section">
        <h2>Featured Watches</h2>
        <div class="products-grid">
            <?php
            $result = $conn->query("SELECT * FROM products ORDER BY RAND() LIMIT 8");
            while($product = $result->fetch_assoc()):
            ?>
                <div class="product-card">
                    <img src="/assets/images/watches/<?php echo $product['image']; ?>" alt="<?php echo $product['model']; ?>" />
                    <h4><?php echo $product['model']; ?></h4>
                    <p class="brand-name"><?php echo $product['brand']; ?></p>
                    <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                    <p class="gender"><?php echo $product['gender']; ?></p>
                    <a href="/add-to-cart.php?product_id=<?php echo $product['id']; ?>" class="btn-add-cart">Add to Cart</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>
