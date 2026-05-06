<?php
session_start();
include('config/database.php');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

if(isset($_POST['cart_id']) && isset($_POST['change'])) {
    $cart_id = $_POST['cart_id'];
    $change = $_POST['change'];
    
    $sql = "SELECT quantity, food_id FROM cart WHERE id=$cart_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $new_qty = $row['quantity'] + $change;
    
    if($new_qty <= 0) {
        mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id");
        echo json_encode(['success' => true, 'removed' => true]);
    } else {
        mysqli_query($conn, "UPDATE cart SET quantity=$new_qty WHERE id=$cart_id");
        echo json_encode(['success' => true]);
    }
}
?>