<?php 
// No PHP code needed here, just closing any open tags if any
?>

<!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <h3>FoodHub</h3>
                <p>Delicious food delivered to your doorstep</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a></li>
                    <li><a href="<?php echo SITEURL; ?>foods.php">Foods</a></li>
                    <li><a href="<?php echo SITEURL; ?>about.php">About Us</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 FoodHub. All rights reserved. Designed with ❤️ by Saintgits</p>
        </div>
    </div>
</footer>

<style>
    .footer {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: white;
        padding: 40px 0 20px;
        margin-top: 50px;
    }
    
    .footer-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .footer-logo h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #ff6b6b;
    }
    
    .footer-logo p {
        opacity: 0.8;
        font-size: 14px;
    }
    
    .footer-links h4,
    .footer-social h4 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #ff6b6b;
    }
    
    .footer-links ul {
        list-style: none;
        padding: 0;
    }
    
    .footer-links ul li {
        margin-bottom: 8px;
    }
    
    .footer-links ul li a {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: 0.3s;
    }
    
    .footer-links ul li a:hover {
        opacity: 1;
        color: #ff6b6b;
    }
    
    .social-icons {
        display: flex;
        gap: 15px;
    }
    
    .social-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: 0.3s;
    }
    
    .social-icon:hover {
        background: #ff6b6b;
        transform: translateY(-3px);
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        opacity: 0.7;
        font-size: 14px;
    }
</style>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php 
// Closing PHP tag if needed
?>