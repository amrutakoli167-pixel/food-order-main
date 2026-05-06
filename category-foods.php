<?php 
include('config/database.php'); 
include('partials-front/menu.php');

// Get category ID from URL
if(isset($_GET['category_id'])) {
    $category_id = mysqli_real_escape_string($conn, $_GET['category_id']);
    
    $cat_sql = "SELECT * FROM tbl_category WHERE id='$category_id' AND active='Yes'";
    $cat_res = mysqli_query($conn, $cat_sql);
    $cat_count = mysqli_num_rows($cat_res);
    
    if($cat_count == 1) {
        $cat_row = mysqli_fetch_assoc($cat_res);
        $category_title = $cat_row['title'];
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!-- Category Header -->
<section class="category-header">
    <div class="container">
        <?php 
        // Local category banner images
        $cat_bg = '';
        if($category_title == 'Biryani & Curries') {
            $cat_bg = 'images/category/biryani-category.jpg';
        } elseif($category_title == 'Starters') {
            $cat_bg = 'images/category/starters-category.jpg';
        } elseif($category_title == 'Beverages') {
            $cat_bg = 'images/category/beverages-category.jpg';
        } elseif($category_title == 'Breads') {
            $cat_bg = 'images/category/breads-category.jpg';
        } elseif($category_title == 'Pizza') {
            $cat_bg = 'images/category/pizza-category.jpg';
        } elseif($category_title == 'Burger') {
            $cat_bg = 'images/category/burger-category.jpg';
        } elseif($category_title == 'Coffee & Tea') {
            $cat_bg = 'images/category/coffee-category.jpg';
        } elseif($category_title == 'Chicken') {
            $cat_bg = 'images/category/chicken-category.jpg';
        } elseif($category_title == 'Paneer') {
            $cat_bg = 'images/category/paneer-category.jpg';
        } else {
            $cat_bg = 'https://via.placeholder.com/1200x300/667eea/FFFFFF?text=' . urlencode($category_title);
        }
        ?>
        <div class="category-banner" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('<?php echo SITEURL . $cat_bg; ?>');">
            <div class="banner-content">
                <h1><?php echo $category_title; ?></h1>
                <p>Explore our delicious <?php echo $category_title; ?> collection</p>
            </div>
        </div>
    </div>
</section>

<!-- Foods Section -->
<section class="foods-section">
    <div class="container">
        <div class="section-heading">
            <h2>Foods on "<?php echo $category_title; ?>"</h2>
            <p>Choose your favorite dish and enjoy the taste</p>
        </div>
        
        <div class="foods-grid">
            <?php 
                $food_sql = "SELECT * FROM tbl_food WHERE category_id='$category_id' AND active='Yes'";
                $food_res = mysqli_query($conn, $food_sql);
                $food_count = mysqli_num_rows($food_res);
                
                if($food_count > 0) {
                    while($food = mysqli_fetch_assoc($food_res)) {
                        $id = $food['id'];
                        $title = $food['title'];
                        $price = $food['price'];
                        $description = $food['description'];
                        
                        // Local Food Images
                        $food_images = [
                            // Beverages
                            'Mango Lassi' => 'images/food/mango-lassi.jpg',
                            'Sweet Lassi' => 'images/food/sweet-lassi.jpg',
                            'Fresh Lime Soda' => 'images/food/lime-soda.jpg',
                            'Fruit Juice' => 'images/food/fruit-juice.jpg',
                            'Milkshake' => 'images/food/milkshake.jpg',
                            'Cold Coffee' => 'images/food/cold-coffee.jpg',
                            'Hot Coffee' => 'images/food/hot-coffee.jpg',
                            'Masala Chai' => 'images/food/masala-chai.jpg',
                            'Green Tea' => 'images/food/green-tea.jpg',
                            'Espresso' => 'images/food/espresso.jpg',
                            'Cappuccino' => 'images/food/cappuccino.jpg',
                            'Latte' => 'images/food/latte.jpg',
                            // Biryani
                            'Chicken Biryani' => 'images/food/chicken-biryani.jpg',
                            'Mutton Biryani' => 'images/food/mutton-biryani.jpg',
                            'Veg Biryani' => 'images/food/veg-biryani.jpg',
                            'Egg Biryani' => 'images/food/egg-biryani.jpg',
                            'Hyderabadi Biryani' => 'images/food/hyderabadi-biryani.jpg',
                            // Chicken
                            'Butter Chicken' => 'images/food/butter-chicken.jpg',
                            'Chicken Lollipop' => 'images/food/chicken-lollipop.jpg',
                            'Chicken Tikka' => 'images/food/chicken-tikka.jpg',
                            'Chicken Curry' => 'images/food/chicken-curry.jpg',
                            'Chicken 65' => 'images/food/chicken-65.jpg',
                            'Tandoori Chicken' => 'images/food/tandoori-chicken.jpg',
                            // Paneer
                            'Paneer Butter Masala' => 'images/food/paneer-butter-masala.jpg',
                            'Chili Paneer' => 'images/food/chili-paneer.jpg',
                            'Paneer Tikka' => 'images/food/paneer-tikka.jpg',
                            'Shahi Paneer' => 'images/food/shahi-paneer.jpg',
                            'Palak Paneer' => 'images/food/palak-paneer.jpg',
                            'Kadai Paneer' => 'images/food/kadai-paneer.jpg',
                            // Pizza
                            'Margherita Pizza' => 'images/food/margherita-pizza.jpg',
                            'Pepperoni Pizza' => 'images/food/pepperoni-pizza.jpg',
                            'Farmhouse Pizza' => 'images/food/farmhouse-pizza.jpg',
                            'Veg Supreme Pizza' => 'images/food/veg-supreme-pizza.jpg',
                            // Burger
                            'Classic Veg Burger' => 'images/food/classic-veg-burger.jpg',
                            'Cheese Burger' => 'images/food/cheese-burger.jpg',
                            'Chicken Burger' => 'images/food/chicken-burger.jpg',
                            'Double Patty Burger' => 'images/food/double-patty-burger.jpg',
                            'Paneer Burger' => 'images/food/paneer-burger.jpg',
                            'Veg Supreme Burger' => 'images/food/veg-supreme-burger.jpg',
                            // Breads
                            'Garlic Naan' => 'images/food/garlic-naan.jpg',
                            'Butter Naan' => 'images/food/butter-naan.jpg',
                            'Tandoori Roti' => 'images/food/tandoori-roti.jpg',
                            'Stuffed Kulcha' => 'images/food/stuffed-kulcha.jpg',
                            'Laccha Paratha' => 'images/food/laccha-paratha.jpg',
                            // Starters
                            'Veg Spring Roll' => 'images/food/spring-roll.jpg',
                            'Veg Manchurian' => 'images/food/veg-manchurian.jpg'
                        ];
                        $img = isset($food_images[$title]) ? $food_images[$title] : 'images/food/default.jpg';
                        
                        // Ratings
                        $ratings_data = [
                            'Mango Lassi' => 5.0, 'Sweet Lassi' => 4.5, 'Fresh Lime Soda' => 4.2,
                            'Fruit Juice' => 4.3, 'Milkshake' => 4.4, 'Cold Coffee' => 4.7,
                            'Hot Coffee' => 4.5, 'Masala Chai' => 4.0, 'Green Tea' => 4.2,
                            'Espresso' => 4.4, 'Cappuccino' => 4.6, 'Latte' => 4.5,
                            'Chicken Biryani' => 4.6, 'Mutton Biryani' => 4.8, 'Veg Biryani' => 4.2,
                            'Egg Biryani' => 4.3, 'Hyderabadi Biryani' => 4.7,
                            'Butter Chicken' => 5.0, 'Chicken Lollipop' => 4.6, 'Chicken Tikka' => 4.5,
                            'Chicken Curry' => 4.4, 'Chicken 65' => 4.3, 'Tandoori Chicken' => 4.6,
                            'Paneer Butter Masala' => 4.5, 'Chili Paneer' => 4.5, 'Paneer Tikka' => 4.4,
                            'Shahi Paneer' => 4.6, 'Palak Paneer' => 4.3, 'Kadai Paneer' => 4.4,
                            'Margherita Pizza' => 4.5, 'Pepperoni Pizza' => 4.7, 'Farmhouse Pizza' => 4.4,
                            'Veg Supreme Pizza' => 4.3, 'Classic Veg Burger' => 4.3, 'Cheese Burger' => 4.7,
                            'Chicken Burger' => 4.5, 'Double Patty Burger' => 4.8, 'Paneer Burger' => 4.4,
                            'Veg Supreme Burger' => 4.2, 'Garlic Naan' => 4.3, 'Butter Naan' => 4.2,
                            'Tandoori Roti' => 4.0, 'Stuffed Kulcha' => 4.1, 'Laccha Paratha' => 4.2,
                            'Veg Spring Roll' => 4.1, 'Veg Manchurian' => 4.2
                        ];
                        $rating = isset($ratings_data[$title]) ? $ratings_data[$title] : 4.0;
                        $full_stars = floor($rating);
                        $half_star = ($rating - $full_stars) >= 0.5;
            ?>
            <div class="food-item">
                <div class="food-image">
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>">
                        <img src="<?php echo SITEURL . $img; ?>" alt="<?php echo $title; ?>">
                    </a>
                    <?php if($price < 100): ?>
                        <span class="sale-badge">SALE</span>
                    <?php endif; ?>
                </div>
                <div class="food-details">
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
                    echo '<div class="empty-state">
                            <i class="fas fa-utensils"></i>
                            <h3>No Foods Found</h3>
                            <p>No foods available in this category yet.</p>
                            <a href="'.SITEURL.'foods.php" class="browse-btn">Browse All Foods</a>
                          </div>';
                }
            ?>
        </div>
    </div>
</section>

<!-- Back Link -->
<div class="back-link">
    <div class="container">
        <a href="<?php echo SITEURL; ?>">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background: #f8f9fa;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .category-header {
        margin-top: 70px;
    }
    
    .category-banner {
        height: 280px;
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin: 20px 0;
    }
    
    .banner-content h1 {
        font-size: 48px;
        color: #fff;
        margin-bottom: 10px;
        font-weight: 700;
    }
    
    .banner-content p {
        font-size: 18px;
        color: rgba(255,255,255,0.9);
    }
    
    .section-heading {
        text-align: center;
        margin: 50px 0 40px;
    }
    
    .section-heading h2 {
        font-size: 36px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    
    .section-heading p {
        color: #666;
        font-size: 16px;
    }
    
    .foods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .food-item {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .food-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .food-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    
    .food-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .food-item:hover .food-image img {
        transform: scale(1.05);
    }
    
    .sale-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ff6b6b;
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .food-details {
        padding: 20px;
    }
    
    .food-details h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
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
    
    .food-details p {
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
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .order-btn:hover {
        transform: translateX(5px);
        color: #fff;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 20px;
        grid-column: 1 / -1;
    }
    
    .empty-state i {
        font-size: 64px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .browse-btn {
        display: inline-block;
        background: #1a1a2e;
        color: #fff;
        text-decoration: none;
        padding: 12px 30px;
        border-radius: 40px;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .browse-btn:hover {
        background: #ff6b6b;
    }
    
    .back-link {
        text-align: center;
        margin: 30px 0 60px;
    }
    
    .back-link a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .back-link a:hover {
        color: #ff6b6b;
        transform: translateX(-5px);
    }
    
    @media (max-width: 768px) {
        .banner-content h1 { font-size: 32px; }
        .section-heading h2 { font-size: 28px; }
        .foods-grid { grid-template-columns: 1fr; }
        .price-rating { flex-direction: column; align-items: flex-start; }
    }
</style>

<?php include('partials-front/footer.php'); ?>