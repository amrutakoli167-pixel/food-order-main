<?php 
if(!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub - Order Food Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <i class="fas fa-utensils"></i> FoodHub
            </a>
        </div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search for restaurant, cuisine or dish...">
            <button onclick="searchRestaurant()"><i class="fas fa-search"></i></button>
        </div>
        <div class="nav-links">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCount" class="cart-count">0</span></a>
                <a href="orders.php"><i class="fas fa-receipt"></i> Orders</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <a href="#" class="user-name"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['user_name']; ?></a>
            <?php else: ?>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Sign In</a>
                <a href="register.php" class="btn-signup">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
function searchRestaurant() {
    let search = document.getElementById('searchInput').value;
    if(search) {
        window.location.href = 'search.php?q=' + encodeURIComponent(search);
    }
}

// Update cart count
function updateCartCount() {
    fetch('get-cart-count.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('cartCount').innerText = data.count;
        });
}
setInterval(updateCartCount, 5000);
updateCartCount();
</script>