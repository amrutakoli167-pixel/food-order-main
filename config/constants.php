<?php
// Start Session - Check if session is not already started
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration - Check if constants are already defined
if(!defined('DB_HOST')) {
    define('DB_HOST', 'localhost:3307');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'food_order');
}

// Create Connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

// Check Connection
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Keep connection alive
mysqli_query($conn, "SET SESSION wait_timeout = 28800");
mysqli_query($conn, "SET SESSION interactive_timeout = 28800");

// Select Database
$db_select = mysqli_select_db($conn, DB_NAME);
if(!$db_select) {
    die("Database selection failed: " . mysqli_error($conn));
}

// Site URL - Check if already defined
if(!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/food-order-main/');
}
?>