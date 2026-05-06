<?php 
include('config/database.php'); 
include('partials-front/menu.php'); 
?>

<style>
    .categories-page {
        background: linear-gradient(135deg, #f5f7fa, #e4e8f0);
        padding: 80px 0;
        min-height: 70vh;
    }
    
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 0 20px;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .page-header h1 {
        font-size: 48px;
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
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }
    
    .category-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: block;
        height: 280px;
        text-decoration: none;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .category-card:hover .category-image {
        transform: scale(1.05);
    }
    
    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 25px;
        text-align: center;
    }
    
    .category-title {
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .category-count {
        background: #ff6b6b;
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
    }
    
    .explore-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 5px 12px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 500;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }
    
    .category-card:hover .explore-badge {
        opacity: 1;
        transform: translateX(0);
    }
    
    @media (max-width: 768px) {
        .categories-page {
            padding: 50px 0;
        }
        .page-header h1 {
            font-size: 32px;
        }
        .categories-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .category-card {
            height: 220px;
        }
    }
</style>

<section class="categories-page">
    <div class="container">
        <div class="page-header">
            <h1>🍽️ Explore Our Categories</h1>
            <p>Discover delicious meals from our curated collection</p>
        </div>
        
        <div class="categories-grid">
            <?php 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        
                        // LOCAL IMAGE PATH - बरोबर फाईल नावे
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
                        
                        $image_path = isset($cat_images[$title]) ? $cat_images[$title] : 'images/category/default.jpg';
                        
                        // Food count
                        $count_sql = "SELECT COUNT(*) as total FROM tbl_food WHERE category_id='$id' AND active='Yes'";
                        $count_res = mysqli_query($conn, $count_sql);
                        $count_row = mysqli_fetch_assoc($count_res);
                        $food_count = $count_row['total'];
            ?>
            <a href="category-foods.php?category_id=<?php echo $id; ?>" class="category-card">
                <img src="<?php echo SITEURL . $image_path . '?v=' . time(); ?>" alt="<?php echo $title; ?>" class="category-image">
                <div class="category-overlay">
                    <h3 class="category-title"><?php echo $title; ?></h3>
                    <span class="category-count"><?php echo $food_count; ?> items</span>
                </div>
                <span class="explore-badge">Explore →</span>
            </a>
            <?php 
                    }
                } else {
                    echo '<div class="no-categories">
                            <i class="fas fa-utensils"></i>
                            <h3>No Categories Found</h3>
                            <p>Categories will be added soon!</p>
                          </div>';
                }
            ?>
        </div>
    </div>
</section>

<style>
    .no-categories {
        text-align: center;
        padding: 80px;
        background: white;
        border-radius: 20px;
        grid-column: 1 / -1;
    }
    .no-categories i {
        font-size: 64px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    .no-categories h3 {
        font-size: 24px;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
</style>

<?php include('partials-front/footer.php'); ?>