<?php 
include('config/database.php'); 
include('partials-front/menu.php');
?>

<style>
    .foods-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 70vh;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .page-header h1 {
        font-size: 42px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
    }
    
    .page-header p {
        font-size: 18px;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .foods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }
    
    .food-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .food-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .food-img {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    
    .food-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .food-card:hover .food-img img {
        transform: scale(1.05);
    }
    
    .food-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ff6b6b;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .food-info {
        padding: 20px;
    }
    
    .food-info h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1a1a2e;
    }
    
    .price-rating {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .price {
        font-size: 22px;
        font-weight: 700;
        color: #ff6b6b;
    }
    
    .price span {
        font-size: 12px;
        color: #999;
        font-weight: normal;
    }
    
    .rating {
        color: #ffc107;
        font-size: 13px;
    }
    
    .rating span {
        color: #666;
        margin-left: 5px;
        font-size: 12px;
    }
    
    .food-info p {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    
    .order-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .order-btn:hover {
        transform: translateX(5px);
        color: white;
    }
    
    .no-foods {
        text-align: center;
        padding: 80px;
        background: white;
        border-radius: 20px;
        grid-column: 1 / -1;
    }
    
    .no-foods i {
        font-size: 64px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .foods-page {
            padding: 50px 0;
        }
        
        .page-header h1 {
            font-size: 32px;
        }
        
        .foods-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="foods-page">
    <div class="container">
        <div class="page-header">
            <h1>🍽️ Food Menu</h1>
            <p>Explore our delicious collection of handcrafted dishes</p>
        </div>
        
        <div class="foods-grid">
            <?php 
                $sql = "SELECT * FROM tbl_food WHERE active='Yes' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
                    while($food = mysqli_fetch_assoc($res)) {
                        $id = $food['id'];
                        $title = $food['title'];
                        $price = $food['price'];
                        $description = $food['description'];
                        
                        // ========== LOCAL FOOD IMAGES ==========
                        $food_images = [
                            // PIZZA
                            'Margherita Pizza' => 'images/food/margherita-pizza.jpg',
                            'Pepperoni Pizza' => 'images/food/pepperoni-pizza.jpg',
                            'Farmhouse Pizza' => 'images/food/farmhouse-pizza.jpg',
                            'Veg Supreme Pizza' => 'images/food/veg-supreme-pizza.jpg',
                            // BURGER
                            'Classic Veg Burger' => 'images/food/classic-veg-burger.jpg',
                            'Cheese Burger' => 'images/food/cheese-burger.jpg',
                            'Chicken Burger' => 'images/food/chicken-burger.jpg',
                            'Double Patty Burger' => 'images/food/double-patty-burger.jpg',
                            'Paneer Burger' => 'images/food/paneer-burger.jpg',
                            'Veg Supreme Burger' => 'images/food/veg-supreme-burger.jpg',
                            // BIRYANI
                            'Chicken Biryani' => 'images/food/chicken-biryani.jpg',
                            'Mutton Biryani' => 'images/food/mutton-biryani.jpg',
                            'Veg Biryani' => 'images/food/veg-biryani.jpg',
                            'Egg Biryani' => 'images/food/egg-biryani.jpg',
                            'Hyderabadi Biryani' => 'images/food/hyderabadi-biryani.jpg',
                            // COFFEE & TEA
                            'Cold Coffee' => 'images/food/cold-coffee.jpg',
                            'Hot Coffee' => 'images/food/hot-coffee.jpg',
                            'Masala Chai' => 'images/food/masala-chai.jpg',
                            'Green Tea' => 'images/food/green-tea.jpg',
                            'Espresso' => 'images/food/espresso.jpg',
                            'Cappuccino' => 'images/food/cappuccino.jpg',
                            'Latte' => 'images/food/latte.jpg',
                            // CHICKEN
                            'Butter Chicken' => 'images/food/butter-chicken.jpg',
                            'Chicken Lollipop' => 'images/food/chicken-lollipop.jpg',
                            'Chicken Tikka' => 'images/food/chicken-tikka.jpg',
                            'Chicken Curry' => 'images/food/chicken-curry.jpg',
                            'Chicken 65' => 'images/food/chicken-65.jpg',
                            'Tandoori Chicken' => 'images/food/tandoori-chicken.jpg',
                            // BREADS
                            'Garlic Naan' => 'images/food/garlic-naan.jpg',
                            'Butter Naan' => 'images/food/butter-naan.jpg',
                            'Tandoori Roti' => 'images/food/tandoori-roti.jpg',
                            'Stuffed Kulcha' => 'images/food/stuffed-kulcha.jpg',
                            'Laccha Paratha' => 'images/food/laccha-paratha.jpg',
                            // PANEER
                            'Paneer Butter Masala' => 'images/food/paneer-butter-masala.jpg',
                            'Chili Paneer' => 'images/food/chili-paneer.jpg',
                            'Paneer Tikka' => 'images/food/paneer-tikka.jpg',
                            'Shahi Paneer' => 'images/food/shahi-paneer.jpg',
                            'Palak Paneer' => 'images/food/palak-paneer.jpg',
                            'Kadai Paneer' => 'images/food/kadai-paneer.jpg',
                            // BEVERAGES
                            'Mango Lassi' => 'images/food/mango-lassi.jpg',
                            'Sweet Lassi' => 'images/food/sweet-lassi.jpg',
                            'Fresh Lime Soda' => 'images/food/lime-soda.jpg',
                            'Fruit Juice' => 'images/food/fruit-juice.jpg',
                            'Milkshake' => 'images/food/milkshake.jpg',
                            // STARTERS
                            'Veg Spring Roll' => 'images/food/spring-roll.jpg',
                            'Veg Manchurian' => 'images/food/veg-manchurian.jpg'
                        ];
                        $img = isset($food_images[$title]) ? $food_images[$title] : 'https://via.placeholder.com/300x200/FF6B6B/FFFFFF?text=' . urlencode($title);
                        
                        // ========== COMPLETE RATINGS ==========
                        $ratings_data = [
                            // Pizza
                            'Margherita Pizza' => 4.5, 'Pepperoni Pizza' => 4.7, 'Farmhouse Pizza' => 4.4, 'Veg Supreme Pizza' => 4.3,
                            // Burger
                            'Classic Veg Burger' => 4.3, 'Cheese Burger' => 4.7, 'Chicken Burger' => 4.5, 'Double Patty Burger' => 4.8,
                            'Paneer Burger' => 4.4, 'Veg Supreme Burger' => 4.2,
                            // Biryani
                            'Chicken Biryani' => 4.6, 'Mutton Biryani' => 4.8, 'Veg Biryani' => 4.2, 'Egg Biryani' => 4.3, 'Hyderabadi Biryani' => 4.7,
                            // Coffee & Tea
                            'Cold Coffee' => 4.7, 'Hot Coffee' => 4.5, 'Masala Chai' => 4.0, 'Green Tea' => 4.2, 'Espresso' => 4.4,
                            'Cappuccino' => 4.6, 'Latte' => 4.5,
                            // Chicken
                            'Butter Chicken' => 5.0, 'Chicken Lollipop' => 4.6, 'Chicken Tikka' => 4.5, 'Chicken Curry' => 4.4,
                            'Chicken 65' => 4.3, 'Tandoori Chicken' => 4.6,
                            // Breads
                            'Garlic Naan' => 4.3, 'Butter Naan' => 4.2, 'Tandoori Roti' => 4.0, 'Stuffed Kulcha' => 4.1, 'Laccha Paratha' => 4.2,
                            // Paneer
                            'Paneer Butter Masala' => 4.5, 'Chili Paneer' => 4.5, 'Paneer Tikka' => 4.4, 'Shahi Paneer' => 4.6,
                            'Palak Paneer' => 4.3, 'Kadai Paneer' => 4.4,
                            // Beverages
                            'Mango Lassi' => 5.0, 'Sweet Lassi' => 4.5, 'Fresh Lime Soda' => 4.2, 'Fruit Juice' => 4.3, 'Milkshake' => 4.4,
                            // Starters
                            'Veg Spring Roll' => 4.1, 'Veg Manchurian' => 4.2
                        ];
                        $rating = isset($ratings_data[$title]) ? $ratings_data[$title] : 4.0;
                        $full_stars = floor($rating);
                        $half_star = ($rating - $full_stars) >= 0.5;
            ?>
            <div class="food-card">
                <div class="food-img">
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>">
                        <img src="<?php echo SITEURL . $img; ?>" alt="<?php echo $title; ?>">
                    </a>
                    <?php if($price < 100): ?>
                        <span class="food-tag">SALE</span>
                    <?php endif; ?>
                </div>
                <div class="food-info">
                    <h3><?php echo $title; ?></h3>
                    <div class="price-rating">
                        <div class="price">₹ <?php echo $price; ?> <span>/ plate</span></div>
                        <div class="rating">
                            <?php
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= $full_stars) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif($half_star && $i == $full_stars + 1) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                    $half_star = false;
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                            <span>(<?php echo $rating; ?>)</span>
                        </div>
                    </div>
                    <p><?php echo substr($description, 0, 70); ?>...</p>
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="order-btn">Order Now →</a>
                </div>
            </div>
            <?php 
                    }
                } else {
                    echo '<div class="no-foods">
                            <i class="fas fa-utensils"></i>
                            <h3>No Foods Found</h3>
                            <p>Check back later for delicious options!</p>
                          </div>';
                }
            ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>