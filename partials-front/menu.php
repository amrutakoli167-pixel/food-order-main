<?php 
// Start session first
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
include('config/database.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub - Order Food Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>">
                    <img src="<?php echo SITEURL; ?>images/logo.png" alt="FoodHub" style="height: 50px; width: auto;">
                </a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
                    <li><a href="<?php echo SITEURL; ?>foods.php"><i class="fas fa-utensils"></i> Foods</a></li>
                    <li><a href="<?php echo SITEURL; ?>about.php"><i class="fas fa-info-circle"></i> About</a></li>
                    <li><a href="<?php echo SITEURL; ?>contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
                    <li><a href="<?php echo SITEURL; ?>offers.php"><i class="fas fa-tags"></i> Offers</a></li>
                    <li><a href="<?php echo SITEURL; ?>track-order.php"><i class="fas fa-truck"></i> Track Order</a></li>
                    <li><a href="<?php echo SITEURL; ?>feedback.php"><i class="fas fa-star"></i> Feedback</a></li>
                    <?php
                        // Session मध्ये user_id आहे का ते check करा
                        if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
                        {
                            echo '<li><a href="'.SITEURL.'login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
                            echo '<li><a href="'.SITEURL.'register.php" class="register-btn"><i class="fas fa-user-plus"></i> Register</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="'.SITEURL.'myorders.php"><i class="fas fa-shopping-bag"></i> My Orders</a></li>';
                            echo '<li><a href="'.SITEURL.'order-history.php"><i class="fas fa-history"></i> Order History</a></li>';
                            echo '<li class="user-name"><a href="'.SITEURL.'profile.php"><i class="fas fa-user-circle"></i> '.$_SESSION['user_name'].'</a></li>';
                            echo '<li><a href="'.SITEURL.'logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </nav>