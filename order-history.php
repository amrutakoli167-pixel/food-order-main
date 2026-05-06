<?php 
include('config/database.php'); 
include('partials-front/menu.php');

// Get email from session if logged in
$customer_email = '';
if(isset($_SESSION['user_email'])) {
    $customer_email = $_SESSION['user_email'];
} else {
    header("Location: login.php");
    exit();
}
?>

<style>
    .history-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 70vh;
    }
    
    .history-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .history-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .orders-table {
        background: white;
        border-radius: 20px;
        overflow-x: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }
    
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        color: #555;
    }
    
    tr:hover {
        background: #f8f9fa;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-ordered { background: #ffc107; color: #1a1a2e; }
    .status-preparing { background: #667eea; color: white; }
    .status-out { background: #ff6b6b; color: white; }
    .status-delivered { background: #28a745; color: white; }
    
    .btn-track-small {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-track-small:hover {
        transform: scale(1.02);
        color: white;
    }
    
    .no-orders {
        text-align: center;
        padding: 60px;
    }
    
    .no-orders i {
        font-size: 64px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .history-header h1 {
            font-size: 32px;
        }
        .orders-table {
            font-size: 14px;
        }
        th, td {
            padding: 10px;
        }
    }
</style>

<section class="history-page">
    <div class="container">
        <div class="history-header">
            <h1>📋 Order History</h1>
            <p>View all your past orders</p>
        </div>
        
        <div class="orders-table">
            <?php 
                $sql = "SELECT * FROM tbl_order WHERE customer_email='$customer_email' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0):
            ?>
             <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Food</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = mysqli_fetch_assoc($res)): 
                        $status_class = '';
                        if($order['status'] == 'Ordered') $status_class = 'status-ordered';
                        elseif($order['status'] == 'Preparing') $status_class = 'status-preparing';
                        elseif($order['status'] == 'Out for Delivery') $status_class = 'status-out';
                        else $status_class = 'status-delivered';
                    ?>
                    <tr>
                        <td>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo $order['food']; ?></td>
                        <td><?php echo $order['qty']; ?></td>
                        <td>₹ <?php echo $order['total']; ?></td>
                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $order['status']; ?></span></td>
                        <td><a href="track-order.php?order_id=<?php echo $order['id']; ?>" class="btn-track-small">Track</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
             </table>
            <?php else: ?>
            <div class="no-orders">
                <i class="fas fa-shopping-bag"></i>
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="foods.php" class="btn-see-all" style="display: inline-block; margin-top: 20px;">Browse Foods</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>