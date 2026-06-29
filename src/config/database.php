<?php
define('DB_HOST', 'db');
define('DB_NAME', 'watchstore');
define('DB_USER', 'watchuser');
define('DB_PASS', 'watchpass');

function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function initDatabase() {
    $conn = getDBConnection();
    
    // Create users table
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create products table
    $conn->query("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        brand VARCHAR(50) NOT NULL,
        model VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        gender ENUM('Men','Women','Unisex') DEFAULT 'Unisex',
        image VARCHAR(255) NOT NULL,
        banner VARCHAR(255),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create cart table
    $conn->query("CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
        UNIQUE KEY unique_cart_item (user_id, product_id)
    )");

    // Insert sample products if empty
    $result = $conn->query("SELECT COUNT(*) as count FROM products");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $watches = [
            // Titan Watches (8 models)
            ['Titan', 'Nebula Blue', 12500, 'Men', 'titan1.jpg', 'titan_banner.jpg', 'Premium titanium case with blue dial'],
            ['Titan', 'Stellar Rose', 15999, 'Women', 'titan2.jpg', 'titan_banner.jpg', 'Rose gold plated with diamond accents'],
            ['Titan', 'Edge Chrono', 18900, 'Men', 'titan3.jpg', 'titan_banner.jpg', 'Chronograph with carbon fiber dial'],
            ['Titan', 'Celestial Gold', 22500, 'Women', 'titan4.jpg', 'titan_banner.jpg', '18K gold plated with mother of pearl'],
            ['Titan', 'Asteroid Black', 9999, 'Men', 'titan5.jpg', 'titan_banner.jpg', 'Black PVD coating with leather strap'],
            ['Titan', 'Lunar White', 13999, 'Women', 'titan6.jpg', 'titan_banner.jpg', 'White ceramic with diamond markers'],
            ['Titan', 'Pulsar Silver', 17999, 'Men', 'titan7.jpg', 'titan_banner.jpg', 'Silver stainless steel with blue dial'],
            ['Titan', 'Venus Pink', 14999, 'Women', 'titan8.jpg', 'titan_banner.jpg', 'Pink dial with rose gold bracelet'],
            
            // Casio Watches (8 models)
            ['Casio', 'G-Shock GA-2100', 8995, 'Men', 'casio1.jpg', 'casio_banner.jpg', 'Carbon core guard structure'],
            ['Casio', 'Edifice EFR-539', 12995, 'Men', 'casio2.jpg', 'casio_banner.jpg', 'Sapphire crystal with chronograph'],
            ['Casio', 'Sheen SHE-4542', 10995, 'Women', 'casio3.jpg', 'casio_banner.jpg', 'Elegant design with Swarovski crystals'],
            ['Casio', 'G-Shock GM-5600', 15995, 'Men', 'casio4.jpg', 'casio_banner.jpg', 'Full metal square design'],
            ['Casio', 'Vintage A158', 3995, 'Unisex', 'casio5.jpg', 'casio_banner.jpg', 'Retro digital with metal strap'],
            ['Casio', 'Edifice EQB-1000', 24995, 'Men', 'casio6.jpg', 'casio_banner.jpg', 'Tough Solar with Bluetooth'],
            ['Casio', 'Sheen SHE-4040', 7995, 'Women', 'casio7.jpg', 'casio_banner.jpg', 'Classic elegance with diamond bezel'],
            ['Casio', 'G-Shock GBD-200', 16995, 'Men', 'casio8.jpg', 'casio_banner.jpg', 'MIP display with step tracker'],
            
            // Sonata Watches (8 models)
            ['Sonata', 'Urban Classic', 3995, 'Men', 'sonata1.jpg', 'sonata_banner.jpg', 'Classic design with stainless steel'],
            ['Sonata', 'Elegant Rose', 4995, 'Women', 'sonata2.jpg', 'sonata_banner.jpg', 'Rose gold with floral dial'],
            ['Sonata', 'Sport Chrono', 5995, 'Men', 'sonata3.jpg', 'sonata_banner.jpg', 'Sporty chronograph with tachymeter'],
            ['Sonata', 'Diamond Quartz', 6995, 'Women', 'sonata4.jpg', 'sonata_banner.jpg', 'Quartz with diamond markers'],
            ['Sonata', 'Steel Blue', 2995, 'Men', 'sonata5.jpg', 'sonata_banner.jpg', 'Blue dial with steel bracelet'],
            ['Sonata', 'Golden Pearl', 7995, 'Women', 'sonata6.jpg', 'sonata_banner.jpg', 'Gold plated with pearl dial'],
            ['Sonata', 'Titanium Edge', 9995, 'Men', 'sonata7.jpg', 'sonata_banner.jpg', 'Titanium case with sapphire glass'],
            ['Sonata', 'Sapphire Crystal', 8995, 'Women', 'sonata8.jpg', 'sonata_banner.jpg', 'Sapphire glass with diamond bezel'],
            
            // Rolex Watches (8 models)
            ['Rolex', 'Submariner Date', 895000, 'Men', 'rolex1.jpg', 'rolex_banner.jpg', 'Iconic diver watch with date'],
            ['Rolex', 'Lady-Datejust', 725000, 'Women', 'rolex2.jpg', 'rolex_banner.jpg', 'Luxury ladies watch with diamond bezel'],
            ['Rolex', 'Daytona White', 1250000, 'Men', 'rolex3.jpg', 'rolex_banner.jpg', 'Chronograph with white dial'],
            ['Rolex', 'Oyster Perpetual', 550000, 'Women', 'rolex4.jpg', 'rolex_banner.jpg', 'Classic Oyster with perpetual movement'],
            ['Rolex', 'GMT-Master II', 975000, 'Men', 'rolex5.jpg', 'rolex_banner.jpg', 'GMT with ceramic bezel'],
            ['Rolex', 'Yacht-Master', 1050000, 'Men', 'rolex6.jpg', 'rolex_banner.jpg', 'Yacht-Master with platinum bezel'],
            ['Rolex', 'Cellini Moonphase', 1350000, 'Women', 'rolex7.jpg', 'rolex_banner.jpg', 'Moonphase complication with gold case'],
            ['Rolex', 'Sky-Dweller', 1450000, 'Men', 'rolex8.jpg', 'rolex_banner.jpg', 'Dual time zone with annual calendar']
        ];
        
        $stmt = $conn->prepare("INSERT INTO products (brand, model, price, gender, image, banner, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($watches as $watch) {
            $stmt->bind_param("ssdssss", $watch[0], $watch[1], $watch[2], $watch[3], $watch[4], $watch[5], $watch[6]);
            $stmt->execute();
        }
    }
    
    $conn->close();
}

// Initialize database on every request (for demo purposes)
initDatabase();
?>
