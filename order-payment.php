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

// Cash on Delivery payment
if(isset($_POST['cash_payment'])) {
    $payment_method = 'Cash on Delivery';
    $payment_status = 'Pending';
    
    $update = "UPDATE tbl_order SET payment_method='$payment_method', payment_status='$payment_status' WHERE id='$order_id'";
    mysqli_query($conn, $update);
    
    $_SESSION['order'] = "✅ Order placed successfully! You will pay on delivery.";
    header("Location: order-confirm.php?order_id=$order_id");
    exit();
}

// Online Payment
if(isset($_POST['online_payment'])) {
    $payment_method = 'Online Payment';
    $payment_status = 'Completed';
    
    $update = "UPDATE tbl_order SET payment_method='$payment_method', payment_status='$payment_status' WHERE id='$order_id'";
    mysqli_query($conn, $update);
    
    $_SESSION['order'] = "✅ Payment successful! Your order has been confirmed.";
    header("Location: order-confirm.php?order_id=$order_id");
    exit();
}
?>

<style>
    .payment-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 80vh;
    }
    
    .payment-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .order-summary {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .order-summary h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ff6b6b;
    }
    
    .order-detail {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-detail:last-child {
        border-bottom: none;
    }
    
    .payment-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .payment-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #e0e0e0;
    }
    
    .payment-card:hover {
        transform: translateY(-5px);
        border-color: #ff6b6b;
    }
    
    .payment-card i {
        font-size: 48px;
        color: #ff6b6b;
        margin-bottom: 15px;
    }
    
    .payment-card h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .payment-card p {
        font-size: 12px;
        color: #666;
        margin-bottom: 15px;
    }
    
    .btn-pay {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
    }
    
    .btn-pay:hover {
        transform: scale(1.02);
    }
    
    .qr-code {
        text-align: center;
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
    }
    
    .qr-code img {
        width: 150px;
        height: 150px;
        margin-bottom: 10px;
    }
    
    .upi-id {
        background: #f0f0f0;
        padding: 10px;
        border-radius: 10px;
        font-family: monospace;
        font-size: 18px;
        margin-top: 10px;
    }
    
    @media (max-width: 768px) {
        .payment-options {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="payment-page">
    <div class="container payment-container">
        <div class="order-summary">
            <h3>📋 Order Summary</h3>
            <div class="order-detail">
                <span>Order ID</span>
                <strong>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></strong>
            </div>
            <div class="order-detail">
                <span>Food</span>
                <strong><?php echo $order['food']; ?></strong>
            </div>
            <div class="order-detail">
                <span>Quantity</span>
                <strong><?php echo $order['qty']; ?></strong>
            </div>
            <div class="order-detail">
                <span>Total Amount</span>
                <strong style="color: #ff6b6b; font-size: 20px;">₹ <?php echo $order['total']; ?></strong>
            </div>
        </div>
        
        <h3 style="text-align: center; margin-bottom: 20px;">💳 Select Payment Method</h3>
        
        <div class="payment-options">
            <!-- Cash on Delivery -->
            <div class="payment-card">
                <i class="fas fa-money-bill-wave"></i>
                <h4>Cash on Delivery</h4>
                <p>Pay when you receive your order</p>
                <form method="POST">
                    <button type="submit" name="cash_payment" class="btn-pay">Confirm COD</button>
                </form>
            </div>
            
            <!-- Online Payment -->
            <div class="payment-card">
                <i class="fas fa-qrcode"></i>
                <h4>Online Payment</h4>
                <p>Pay via UPI / Card / NetBanking</p>
                <button type="button" class="btn-pay" onclick="showQR()">Pay Online</button>
            </div>
        </div>
        
        <!-- QR Code Section (Shows when online payment is selected) -->
        <div id="qrSection" style="display: none;" class="qr-code">
            <i class="fas fa-qrcode" style="font-size: 48px; color: #1a1a2e;"></i>
            <h4>Scan to Pay</h4>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=foodhub@okhdfcbank&pn=FoodHub&am=<?php echo $order['total']; ?>&cu=INR" alt="QR Code">
            <p>Scan with any UPI app (Google Pay, PhonePe, Paytm)</p>
            <div class="upi-id">
                📱 UPI ID: foodhub@okhdfcbank
            </div>
            <p style="margin-top: 15px; color: #28a745;">
                <i class="fas fa-check-circle"></i> After payment, click "Confirm Payment" below
            </p>
            <form method="POST">
                <button type="submit" name="online_payment" class="btn-pay" style="background: #28a745; margin-top: 10px;">
                    ✅ Confirm Payment
                </button>
            </form>
        </div>
    </div>
</section>

<script>
    function showQR() {
        document.getElementById('qrSection').style.display = 'block';
    }
</script>

<?php include('partials-front/footer.php'); ?>