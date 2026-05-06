<?php 
include('config/database.php'); 
include('partials-front/menu.php');

if(isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
    
    $sql = "SELECT * FROM tbl_order WHERE id='$order_id'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    
    if($count == 1) {
        $order = mysqli_fetch_assoc($res);
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<style>
    .confirm-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 80vh;
    }
    
    .confirm-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: #28a745;
        color: white;
        font-size: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 20px;
    }
    
    .confirm-card h2 {
        font-size: 28px;
        color: #28a745;
        margin-bottom: 15px;
    }
    
    .order-details {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin: 25px 0;
        text-align: left;
    }
    
    .order-details h4 {
        margin-bottom: 15px;
        color: #1a1a2e;
        border-left: 4px solid #ff6b6b;
        padding-left: 10px;
    }
    
    .order-details p {
        margin: 8px 0;
        color: #555;
    }
    
    .order-details strong {
        color: #1a1a2e;
    }
    
    .payment-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .payment-status.completed {
        background: #28a745;
        color: white;
    }
    
    .payment-status.pending {
        background: #ffc107;
        color: #1a1a2e;
    }
    
    .payment-status.cod {
        background: #667eea;
        color: white;
    }
    
    .btn-track {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 12px 30px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        margin: 10px;
        transition: 0.3s;
    }
    
    .btn-track:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-home {
        display: inline-block;
        background: #1a1a2e;
        color: white;
        padding: 12px 30px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        margin: 10px;
        transition: 0.3s;
    }
    
    .btn-home:hover {
        background: #ff6b6b;
        color: white;
    }
    
    @media (max-width: 768px) {
        .confirm-card {
            padding: 25px;
        }
    }
</style>

<section class="confirm-page">
    <div class="container">
        <div class="confirm-card">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Order Confirmed! 🎉</h2>
            <p>Thank you for your order. Your food is being prepared.</p>
            
            <div class="order-details">
                <h4>📋 Order Details</h4>
                <p><strong>Order ID:</strong> #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></p>
                <p><strong>Food:</strong> <?php echo $order['food']; ?></p>
                <p><strong>Quantity:</strong> <?php echo $order['qty']; ?></p>
                <p><strong>Total:</strong> ₹ <?php echo $order['total']; ?></p>
                
                <?php if(isset($order['payment_method']) && $order['payment_method'] != ''): ?>
                <p><strong>Payment Method:</strong> 
                    <?php 
                    if($order['payment_method'] == 'Cash on Delivery') {
                        echo '💵 Cash on Delivery';
                    } elseif($order['payment_method'] == 'Online Payment') {
                        echo '💳 Online Payment (UPI/Card)';
                    } else {
                        echo $order['payment_method'];
                    }
                    ?>
                </p>
                <p><strong>Payment Status:</strong> 
                    <?php 
                    if($order['payment_status'] == 'Completed') {
                        echo '<span class="payment-status completed">✅ Payment Successful</span>';
                    } elseif($order['payment_status'] == 'Pending') {
                        echo '<span class="payment-status pending">⏳ Payment Pending</span>';
                    } else {
                        echo '<span class="payment-status">' . $order['payment_status'] . '</span>';
                    }
                    ?>
                </p>
                <?php endif; ?>
                
                <p><strong>Delivery Address:</strong> <?php echo $order['customer_address']; ?></p>
                <p><strong>Contact:</strong> <?php echo $order['customer_contact']; ?></p>
                <p><strong>Status:</strong> <span style="color: #28a745;">✅ <?php echo $order['status']; ?></span></p>
                <p><strong>Estimated Delivery:</strong> ⏰ <?php echo date('h:i A', strtotime('+30 minutes')); ?></p>
            </div>
            
            <?php if(isset($order['payment_method']) && $order['payment_method'] == 'Cash on Delivery'): ?>
            <div style="background: #f0f0f0; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <p style="margin: 0; color: #ff6b6b;">💡 <strong>Cash on Delivery</strong></p>
                <p style="margin: 5px 0 0; font-size: 12px;">Please keep exact cash ready for delivery</p>
            </div>
            <?php endif; ?>
            
            <?php if(isset($order['payment_method']) && $order['payment_method'] == 'Online Payment'): ?>
            <div style="background: #e8f5e9; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <p style="margin: 0; color: #28a745;">✅ <strong>Payment Successful</strong></p>
                <p style="margin: 5px 0 0; font-size: 12px;">Your payment has been received. Order will be delivered soon!</p>
            </div>
            <?php endif; ?>
            
            <a href="<?php echo SITEURL; ?>myorders.php" class="btn-track">📋 View My Orders</a>
            <a href="<?php echo SITEURL; ?>" class="btn-home">🏠 Back to Home</a>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>