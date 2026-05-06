<?php 
include('config/database.php'); 
include('partials-front/menu.php');

// Check if food_id is set
if(isset($_GET['food_id'])) {
    $food_id = mysqli_real_escape_string($conn, $_GET['food_id']);
    
    // Get food details
    $sql = "SELECT * FROM tbl_food WHERE id='$food_id' AND active='Yes'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    
    if($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $food_title = $row['title'];
        $food_price = $row['price'];
        $food_image = $row['image_name'];
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Order submit
if(isset($_POST['order'])) {
    $food = mysqli_real_escape_string($conn, $_POST['food']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $total = $price * $qty;
    
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
    
    $order_date = date('Y-m-d H:i:s');
    $status = "Ordered";
    
    // Insert into database
    $insert = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address) 
               VALUES ('$food', '$price', '$qty', '$total', '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address')";
    
    $result = mysqli_query($conn, $insert);
    
    if($result) {
        // 👇 हा भाग बदलला आहे - payment page वर redirect
        $_SESSION['order'] = "<i class='fas fa-check-circle'></i> Order placed successfully! Please complete payment.";
        header("Location: order-payment.php?order_id=" . mysqli_insert_id($conn));
        exit();
    } else {
        $_SESSION['order_error'] = "Failed to place order. Please try again.";
        header("Location: order.php?food_id=$food_id");
        exit();
    }
}
?>

<style>
    .order-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 80vh;
    }
    
    .order-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .food-preview {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding: 30px;
        text-align: center;
        color: white;
    }
    
    .food-preview img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
        margin-bottom: 15px;
    }
    
    .food-preview h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .food-preview .price {
        font-size: 28px;
        font-weight: 700;
    }
    
    .form-section {
        padding: 30px;
    }
    
    .form-section h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ff6b6b;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ff6b6b;
    }
    
    .quantity-box {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .quantity-box input {
        width: 80px;
        text-align: center;
    }
    
    .total-price {
        background: #f0f0f0;
        padding: 15px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }
    
    .total-price span {
        font-size: 24px;
        font-weight: 700;
        color: #ff6b6b;
    }
    
    .btn-order {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    @media (max-width: 768px) {
        .order-page {
            padding: 50px 0;
        }
    }
</style>

<section class="order-page">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="order-card">
                    <div class="food-preview">
                        <?php 
                        $food_images = [
                            'Chicken Biryani' => 'https://images.pexels.com/photos/1600727/pexels-photo-1600727.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Mutton Biryani' => 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Veg Biryani' => 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Butter Chicken' => 'https://images.pexels.com/photos/2338407/pexels-photo-2338407.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Paneer Butter Masala' => 'https://images.pexels.com/photos/1279330/pexels-photo-1279330.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Garlic Naan' => 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Mango Lassi' => 'https://images.pexels.com/photos/1092730/pexels-photo-1092730.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Masala Chai' => 'https://images.pexels.com/photos/2918745/pexels-photo-2918745.jpeg?auto=compress&cs=tinysrgb&w=200',
                            'Cold Coffee' => 'https://images.pexels.com/photos/3020919/pexels-photo-3020919.jpeg?auto=compress&cs=tinysrgb&w=200'
                        ];
                        $img = isset($food_images[$food_title]) ? $food_images[$food_title] : 'https://via.placeholder.com/150/FF6B6B/FFFFFF?text=' . urlencode($food_title);
                        ?>
                        <img src="<?php echo $img; ?>" alt="<?php echo $food_title; ?>">
                        <h3><?php echo $food_title; ?></h3>
                        <div class="price">₹ <?php echo $food_price; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="order-card">
                    <div class="form-section">
                        <h4>📝 Delivery Details</h4>
                        
                        <?php if(isset($_SESSION['order_error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['order_error']; unset($_SESSION['order_error']); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="food" value="<?php echo $food_title; ?>">
                            <input type="hidden" name="price" value="<?php echo $food_price; ?>">
                            
                            <div class="form-group">
                                <label>Quantity *</label>
                                <div class="quantity-box">
                                    <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                                    <input type="number" name="qty" id="qty" value="1" min="1" max="10" readonly>
                                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                </div>
                            </div>
                            
                            <div class="total-price">
                                Total Amount: <span id="total">₹ <?php echo $food_price; ?></span>
                            </div>
                            
                            <div class="form-group">
                                <label>Full Name *</label>
                                <input type="text" name="customer_name" placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Phone Number *</label>
                                <input type="tel" name="customer_contact" placeholder="Enter your phone number" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="customer_email" placeholder="Enter your email" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Delivery Address *</label>
                                <textarea name="customer_address" rows="3" placeholder="Enter your complete address" required></textarea>
                            </div>
                            
                            <button type="submit" name="order" class="btn-order">Place Order →</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let price = <?php echo $food_price; ?>;
    let qty = 1;
    
    function changeQty(change) {
        let newQty = qty + change;
        if(newQty >= 1 && newQty <= 10) {
            qty = newQty;
            document.getElementById('qty').value = qty;
            document.getElementById('total').innerHTML = '₹ ' + (price * qty);
        }
    }
</script>

<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    .col-md-5 {
        flex: 0 0 calc(41.666% - 15px);
    }
    .col-md-7 {
        flex: 0 0 calc(58.333% - 15px);
    }
    .qty-btn {
        width: 35px;
        height: 35px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
    }
    .qty-btn:hover {
        background: #ff6b6b;
        color: white;
        border-color: #ff6b6b;
    }
    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    @media (max-width: 768px) {
        .col-md-5, .col-md-7 {
            flex: 0 0 100%;
        }
    }
</style>

<?php include('partials-front/footer.php'); ?>