<?php
echo "Trying to connect...<br>";

$conn = mysqli_connect('localhost:3307', 'root', '');

if($conn) {
    echo "MySQL Connected successfully!<br>";
    
    $db_check = mysqli_select_db($conn, 'food_order');
    if($db_check) {
        echo "Database 'food_order' selected successfully!";
    } else {
        echo "Database selection failed: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
?>