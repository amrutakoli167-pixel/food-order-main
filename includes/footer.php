<!-- Footer -->
<section class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4><i class="fas fa-utensils"></i> FoodHub</h4>
                <p>Order food online from best restaurants near you.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Company</h4>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Careers</a>
                <a href="#">Blog</a>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <a href="#">Help & Support</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Refund Policy</a>
            </div>
            <div class="footer-section">
                <h4>Download App</h4>
                <p>Get the FoodHub app for better experience</p>
                <div class="app-links">
                    <a href="#"><i class="fab fa-google-play"></i> Google Play</a>
                    <a href="#"><i class="fab fa-apple"></i> App Store</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 FoodHub. All rights reserved. Designed with ❤️</p>
        </div>
    </div>
</section>

<script>
// Add notification function
function showNotification(message, type) {
    let notification = document.createElement('div');
    notification.className = 'notification ' + type;
    notification.innerHTML = '<i class="fas ' + (type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') + '"></i> ' + message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Add to window object
window.showNotification = showNotification;
</script>

</body>
</html>