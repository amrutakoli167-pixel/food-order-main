<?php
session_start();
include('config/database.php');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

if(isset($_POST['food_id'])) {
    $user_id = $_SESSION['user_id'];
    $food_id = $_POST['food_id'];
    
    // Check if item already in cart
    $check = "SELECT * FROM cart WHERE user_id=$user_id AND food_id=$food_id";
    $result = mysqli_query($conn, $check);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $new_qty = $row['quantity'] + 1;
        $update = "UPDATE cart SET quantity=$new_qty WHERE id=" . $row['id'];
        mysqli_query($conn, $update);
    } else {
        $insert = "INSERT INTO cart (user_id, food_id, quantity) VALUES ($user_id, $food_id, 1)";
        mysqli_query($conn, $insert);
    }
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>