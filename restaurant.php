<?php 
include('config/database.php'); 
include('includes/header.php');

$restaurant_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM restaurants WHERE id=$restaurant_id AND is_active=1";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$restaurant = mysqli_fetch_assoc($result);
?>

<!-- Restaurant Header -->
<section class="restaurant-header" style="background: linear-gradient(135deg, #2c3e50, #1a252f);">
    <div class="container">
        <div class="restaurant-banner">
            <div class="banner-img">
                <img src="images/restaurants/<?php echo $restaurant['image']; ?>" alt="<?php echo $restaurant['name']; ?>">
            </div>
            <div class="banner-info">
                <h1><?php echo $restaurant['name']; ?></h1>
                <p class="cuisine-type"><?php echo $restaurant['cuisine']; ?></p>
                <div class="restaurant-details">
                    <span class="rating"><i class="fas fa-star"></i> <?php echo $restaurant['rating']; ?></span>
                    <span class="time"><i class="far fa-clock"></i> <?php echo $restaurant['delivery_time']; ?></span>
                    <span class="min-order"><i class="fas fa-rupee-sign"></i> <?php echo $restaurant['min_order']; ?> min</span>
                </div>
                <div class="restaurant-address">
                    <i class="fas fa-map-marker-alt"></i> <?php echo $restaurant['address']; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Restaurant Menu -->
<section class="restaurant-menu">
    <div class="container">
        <h2>Menu</h2>
        
        <div class="menu-tabs">
            <button class="tab-btn active" onclick="filterCategory('all')">All</button>
            <button class="tab-btn" onclick="filterCategory('veg')">Veg</button>
            <button class="tab-btn" onclick="filterCategory('non-veg')">Non-Veg</button>
            <button class="tab-btn" onclick="filterCategory('beverages')">Beverages</button>
        </div>
        
        <div class="menu-grid" id="menuGrid">
            <?php
            $sql_foods = "SELECT * FROM foods WHERE restaurant_id=$restaurant_id AND is_active=1 ORDER BY is_veg DESC, name ASC";
            $result_foods = mysqli_query($conn, $sql_foods);
            
            if(mysqli_num_rows($result_foods) > 0):
                while($food = mysqli_fetch_assoc($result_foods)):
            ?>
            <div class="menu-item" data-category="<?php echo $food['is_veg'] ? 'veg' : 'non-veg'; ?>">
                <div class="item-info">
                    <div class="veg-badge <?php echo $food['is_veg'] ? 'veg' : 'non-veg'; ?>">
                        <i class="fas <?php echo $food['is_veg'] ? 'fa-leaf' : 'fa-drumstick'; ?>"></i>
                        <?php echo $food['is_veg'] ? 'VEG' : 'NON-VEG'; ?>
                    </div>
                    <h3><?php echo $food['name']; ?></h3>
                    <p class="item-desc"><?php echo $food['description']; ?></p>
                    <p class="item-price">₹<?php echo $food['price']; ?></p>
                </div>
                <div class="item-image">
                    <img src="images/foods/<?php echo $food['image']; ?>" alt="<?php echo $food['name']; ?>">
                    <button class="add-to-cart" onclick="addToCart(<?php echo $food['id']; ?>)">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="no-data">
                <i class="fas fa-utensils"></i>
                <p>No menu items available for this restaurant.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
function addToCart(foodId) {
    <?php if(!isset($_SESSION['user_id'])): ?>
        if(confirm('Please login to add items to cart. Login now?')) {
            window.location.href = 'login.php';
        }
        return;
    <?php endif; ?>
    
    fetch('add-to-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'food_id=' + foodId
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showNotification('Item added to cart!', 'success');
            updateCartCount();
        } else {
            showNotification('Failed to add item', 'error');
        }
    });
}

function filterCategory(category) {
    let items = document.querySelectorAll('.menu-item');
    items.forEach(item => {
        if(category === 'all') {
            item.style.display = 'flex';
        } else if(category === 'veg' && item.dataset.category === 'veg') {
            item.style.display = 'flex';
        } else if(category === 'non-veg' && item.dataset.category === 'non-veg') {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Update active tab
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}
</script>

<?php include('includes/footer.php'); ?>