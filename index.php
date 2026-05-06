<?php 
include('config/database.php'); 
include('partials-front/menu.php');
?>

<!-- Hero Search Section -->
<section class="food-search text-center">
    <div class="container">
        <div class="search-box">
            <h2>🍽️ <span class="highlight">Find Your Favorite Food</span></h2>
            <p class="search-subtitle">Search for restaurant, cuisine or dish...</p>
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <div class="search-wrapper">
                    <input type="search" name="search" placeholder="🔍 Search for delicious food..." required>
                    <button type="submit" name="submit" class="btn-search">Search</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php 
if(isset($_SESSION['order'])) {
    echo '<div class="container"><div class="success-msg"><i class="fas fa-check-circle"></i> ' . $_SESSION['order'] . '</div></div>';
    unset($_SESSION['order']);
}
?>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">🍕 Explore Our Categories</h2>
            <p class="section-subtitle">Discover delicious meals from our curated categories</p>
        </div>
        <div class="category-grid">
            <?php 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 4";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0) {
                    while($row=mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        
                        // Category Images - Local
                        $cat_images = [
                            'Biryani & Curries' => 'images/category/biryani-category.jpg',
                            'Starters' => 'images/category/starters-category.jpg',
                            'Beverages' => 'images/category/beverages-category.jpg',
                            'Breads' => 'images/category/breads-category.jpg',
                            'Pizza' => 'images/category/pizza-category.jpg',
                            'Burger' => 'images/category/burger-category.jpg',
                            'Biryani' => 'images/category/biryani-category.jpg',
                            'Coffee & Tea' => 'images/category/coffee-category.jpg',
                            'Chicken' => 'images/category/chicken-category.jpg',
                            'Paneer' => 'images/category/paneer-category.jpg'
                        ];
                        $cat_img = isset($cat_images[$title]) ? $cat_images[$title] : 'images/category/default.jpg';
            ?>
            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>" class="category-card">
                <div class="category-img">
                    <img src="<?php echo SITEURL . $cat_img; ?>" alt="<?php echo $title; ?>">
                    <div class="category-overlay">
                        <h3><?php echo $title; ?></h3>
                        <span class="explore-btn">Explore →</span>
                    </div>
                </div>
            </a>
            <?php 
                    }
                } else {
                    echo "<div class='error'>Category not Added.</div>";
                }
            ?>
        </div>
    </div>
</section>

<!-- Featured Foods Section -->
<section class="featured-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">🔥 Featured Foods</h2>
            <p class="section-subtitle">Most popular dishes loved by our customers</p>
        </div>
        <div class="food-grid">
            <?php 
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                if($count2>0) {
                    while($row=mysqli_fetch_assoc($res2)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        
                        // Food Images - Local
                        $image_urls = [
                            'Chicken Biryani' => 'images/food/chicken-biryani.jpg',
                            'Mutton Biryani' => 'images/food/mutton-biryani.jpg',
                            'Veg Biryani' => 'images/food/veg-biryani.jpg',
                            'Butter Chicken' => 'images/food/butter-chicken.jpg',
                            'Paneer Butter Masala' => 'images/food/paneer-butter-masala.jpg',
                            'Garlic Naan' => 'images/food/garlic-naan.jpg',
                            'Cold Coffee' => 'images/food/cold-coffee.jpg',
                            'Masala Chai' => 'images/food/masala-chai.jpg',
                            'Mango Lassi' => 'images/food/mango-lassi.jpg',
                            'Cheese Burger' => 'images/food/cheese-burger.jpg',
                            'Classic Veg Burger' => 'images/food/classic-veg-burger.jpg',
                            'Margherita Pizza' => 'images/food/margherita-pizza.jpg'
                        ];
                        $img_url = isset($image_urls[$title]) ? $image_urls[$title] : 'images/food/default.jpg';
                        
                        // Ratings
                        $ratings_data = [
                            'Chicken Biryani' => 4.6, 'Mutton Biryani' => 4.8, 'Veg Biryani' => 4.2,
                            'Butter Chicken' => 5.0, 'Paneer Butter Masala' => 4.5, 'Garlic Naan' => 4.3,
                            'Cold Coffee' => 4.7, 'Masala Chai' => 4.0, 'Mango Lassi' => 5.0,
                            'Cheese Burger' => 4.7, 'Classic Veg Burger' => 4.3, 'Margherita Pizza' => 4.5
                        ];
                        $rating = isset($ratings_data[$title]) ? $ratings_data[$title] : 4.0;
                        $full_stars = floor($rating);
                        $half_star = ($rating - $full_stars) >= 0.5;
            ?>
            <div class="food-card">
                <div class="food-img">
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>">
                        <img src="<?php echo SITEURL . $img_url; ?>" alt="<?php echo $title; ?>">
                    </a>
                    <span class="food-tag">⭐ Popular</span>
                </div>
                <div class="food-info">
                    <h4><?php echo $title; ?></h4>
                    <div class="price-rating">
                        <p class="food-price">₹<?php echo $price; ?> <span>+ taxes</span></p>
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
                    <p class="food-desc"><?php echo substr($description, 0, 55); ?>...</p>
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn-order">Order Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <?php 
                    }
                } else {
                    echo "<div class='error'>Food not available.</div>";
                }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo SITEURL; ?>foods.php" class="btn-see-all"><i class="fas fa-utensils"></i> View All Foods</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-truck-fast"></i>
                <h4>Fast Delivery</h4>
                <p>Delivery in 30 minutes</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-medal"></i>
                <h4>Quality Food</h4>
                <p>100% fresh ingredients</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-rupee-sign"></i>
                <h4>Best Price</h4>
                <p>Affordable rates</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-headset"></i>
                <h4>24/7 Support</h4>
                <p>Always here to help</p>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>