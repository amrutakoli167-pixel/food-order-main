<?php 
include('config/database.php'); 
include('partials-front/menu.php');
?>

<style>
    .about-page {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .about-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .about-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .about-header p {
        font-size: 18px;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .about-content {
        background: white;
        border-radius: 30px;
        padding: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 50px;
    }
    
    .about-text h2 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 20px;
    }
    
    .about-text p {
        font-size: 16px;
        line-height: 1.8;
        color: #555;
        margin-bottom: 20px;
    }
    
    .mission-vision {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-top: 40px;
    }
    
    .mission-card, .vision-card {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s;
    }
    
    .mission-card:hover, .vision-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .mission-card i, .vision-card i {
        font-size: 48px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    
    .mission-card h3, .vision-card h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1a1a2e;
    }
    
    .mission-card p, .vision-card p {
        color: #666;
        line-height: 1.6;
    }
    
    .features-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 40px;
    }
    
    .feature-item {
        text-align: center;
        padding: 20px;
    }
    
    .feature-item i {
        font-size: 40px;
        color: #ff6b6b;
        margin-bottom: 15px;
    }
    
    .feature-item h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .feature-item p {
        font-size: 14px;
        color: #666;
    }
    
    .team-section {
        margin-top: 60px;
    }
    
    .team-section h2 {
        text-align: center;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #1a1a2e;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
    }
    
    .team-card {
        text-align: center;
        background: white;
        border-radius: 20px;
        padding: 30px 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .team-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #ff6b6b;
    }
    
    .team-card h4 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .team-card p {
        color: #ff6b6b;
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    @media (max-width: 768px) {
        .mission-vision, .features-list, .team-grid {
            grid-template-columns: 1fr;
        }
        .about-header h1 {
            font-size: 32px;
        }
        .about-content {
            padding: 30px;
        }
    }
</style>

<section class="about-page">
    <div class="container">
        <div class="about-header">
            <h1>🍽️ About FoodHub</h1>
            <p>Delivering happiness through delicious food since 2020</p>
        </div>
        
        <div class="about-content">
            <div class="about-text">
                <h2>Our Story</h2>
                <p>FoodHub started in 2020 with a simple mission - to bring the most delicious and authentic food to your doorstep. What began as a small kitchen has now grown into a beloved food delivery service, serving thousands of satisfied customers across the city.</p>
                <p>We believe that good food has the power to bring people together. That's why we work with the finest chefs, use the freshest ingredients, and ensure every dish is prepared with love and care.</p>
            </div>
            
            <div class="mission-vision">
                <div class="mission-card">
                    <i class="fas fa-bullseye"></i>
                    <h3>Our Mission</h3>
                    <p>To provide high-quality, delicious food that brings joy to every meal, while ensuring excellent service and value for our customers.</p>
                </div>
                <div class="vision-card">
                    <i class="fas fa-eye"></i>
                    <h3>Our Vision</h3>
                    <p>To become the most loved and trusted food delivery service, known for quality, taste, and exceptional customer experience.</p>
                </div>
            </div>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-truck-fast"></i>
                    <h4>Fast Delivery</h4>
                    <p>Delivery in 30 minutes</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-leaf"></i>
                    <h4>Fresh Ingredients</h4>
                    <p>100% fresh and quality</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-rupee-sign"></i>
                    <h4>Best Price</h4>
                    <p>Affordable rates</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-headset"></i>
                    <h4>24/7 Support</h4>
                    <p>Always here to help</p>
                </div>
            </div>
        </div>
        
        <div class="team-section">
            <h2>👨‍🍳 Meet Our Chefs</h2>
            <div class="team-grid">
                <div class="team-card">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Chef">
                    <h4>Chef Vikram Singh</h4>
                    <p>Head Chef - Indian Cuisine</p>
                </div>
                <div class="team-card">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Chef">
                    <h4>Chef Priya Sharma</h4>
                    <p>Specialist - Continental</p>
                </div>
                <div class="team-card">
                    <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Chef">
                    <h4>Chef Rajesh Kumar</h4>
                    <p>Expert - Chinese Cuisine</p>
                </div>
                <div class="team-card">
                    <img src="https://randomuser.me/api/portraits/women/89.jpg" alt="Chef">
                    <h4>Chef Anjali Patel</h4>
                    <p>Master - Desserts</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>