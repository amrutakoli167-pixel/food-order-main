<?php 
include('config/database.php'); 
include('partials-front/menu.php');

$order = null;
$error = '';

if(isset($_POST['track_order'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $sql = "SELECT * FROM tbl_order WHERE id='$order_id' AND customer_email='$email'";
    $res = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($res) > 0) {
        $order = mysqli_fetch_assoc($res);
    } else {
        $error = "Order not found! Please check Order ID and Email.";
    }
}
?>

<style>
    .track-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 70vh;
    }
    
    .track-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .track-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .track-form {
        max-width: 500px;
        margin: 0 auto 50px;
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group input {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 16px;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #ff6b6b;
    }
    
    .btn-track {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .order-status {
        background: white;
        border-radius: 20px;
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .status-steps {
        display: flex;
        justify-content: space-between;
        margin: 40px 0;
        position: relative;
    }
    
    .status-steps::before {
        content: '';
        position: absolute;
        top: 30px;
        left: 10%;
        right: 10%;
        height: 4px;
        background: #e0e0e0;
        z-index: 1;
    }
    
    .step {
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    
    .step-icon {
        width: 60px;
        height: 60px;
        background: #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 24px;
        color: #999;
        transition: all 0.3s;
    }
    
    .step.active .step-icon {
        background: #ff6b6b;
        color: white;
        box-shadow: 0 0 0 5px rgba(255,107,107,0.2);
    }
    
    .step.completed .step-icon {
        background: #28a745;
        color: white;
    }
    
    .step-label {
        font-size: 12px;
        font-weight: 600;
        color: #666;
    }
    
    .step.active .step-label {
        color: #ff6b6b;
    }
    
    .step.completed .step-label {
        color: #28a745;
    }
    
    .order-details {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .error-msg {
        background: #fee2e2;
        color: #dc2626;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .track-header h1 {
            font-size: 32px;
        }
        .status-steps::before {
            display: none;
        }
        .status-steps {
            flex-direction: column;
            gap: 20px;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 15px;
            text-align: left;
        }
        .step-icon {
            margin: 0;
        }
    }
</style>

<section class="track-page">
    <div class="container">
        <div class="track-header">
            <h1>📦 Track Your Order</h1>
            <p>Enter your Order ID and Email to track your order status</p>
        </div>
        
        <div class="track-form">
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="order_id" placeholder="Order ID (e.g., 1, 2, 3...)" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <button type="submit" name="track_order" class="btn-track">Track Order →</button>
            </form>
        </div>
        
        <?php if($error): ?>
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if($order): 
            $status = $order['status'];
            $steps = ['Ordered', 'Preparing', 'Out for Delivery', 'Delivered'];
            $current_step = array_search($status, $steps);
            if($current_step === false) $current_step = 0;
        ?>
        <div class="order-status">
            <h3 style="text-align: center; margin-bottom: 20px;">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h3>
            
            <div class="status-steps">
                <?php foreach($steps as $index => $step): ?>
                <div class="step <?php echo $index <= $current_step ? 'completed' : ''; ?> <?php echo $index == $current_step ? 'active' : ''; ?>">
                    <div class="step-icon">
                        <?php
                        if($step == 'Ordered') echo '<i class="fas fa-shopping-cart"></i>';
                        elseif($step == 'Preparing') echo '<i class="fas fa-utensils"></i>';
                        elseif($step == 'Out for Delivery') echo '<i class="fas fa-truck"></i>';
                        else echo '<i class="fas fa-check-circle"></i>';
                        ?>
                    </div>
                    <div class="step-label"><?php echo $step; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-details">
                <p><strong>🍽️ Food:</strong> <?php echo $order['food']; ?></p>
                <p><strong>🔢 Quantity:</strong> <?php echo $order['qty']; ?></p>
                <p><strong>💰 Total:</strong> ₹ <?php echo $order['total']; ?></p>
                <p><strong>📍 Delivery Address:</strong> <?php echo $order['customer_address']; ?></p>
                <p><strong>📞 Contact:</strong> <?php echo $order['customer_contact']; ?></p>
                <p><strong>⏰ Order Date:</strong> <?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></p>
                <p><strong>🚚 Estimated Delivery:</strong> <?php echo date('h:i A', strtotime($order['order_date'] . ' +30 minutes')); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>