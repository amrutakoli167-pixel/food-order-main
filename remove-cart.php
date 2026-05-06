<?php
session_start();
include('config/database.php');

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

if(isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    mysqli_query($conn, "DELETE FROM cart WHERE id=$cart_id");
    echo json_encode(['success' => true]);
}
?>