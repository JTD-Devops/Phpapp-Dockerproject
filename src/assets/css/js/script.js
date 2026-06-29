document.addEventListener('DOMContentLoaded', function() {
    // Add any JavaScript functionality here
    
    // Example: Add to cart confirmation
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!this.href.includes('login.php')) {
                e.preventDefault();
                const confirmAdd = confirm('Add this item to your cart?');
                if (confirmAdd) {
                    window.location.href = this.href;
                }
            }
        });
    });
    
    // Product card hover effect
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.borderColor = '#d4af37';
        });
        card.addEventListener('mouseleave', function() {
            this.style.borderColor = '#2a2a2a';
        });
    });
});
