<?php 
include('config/database.php'); 
include('partials-front/menu.php');

// Get email from session if logged in, or from GET
$customer_email = '';
if(isset($_SESSION['user_email'])) {
    $customer_email = $_SESSION['user_email'];
} elseif(isset($_GET['email'])) {
    $customer_email = $_GET['email'];
}
?>

<style>
    .myorders-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 70vh;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-header h1 {
        font-size: 36px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    
    .orders-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .orders-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }
    
    .orders-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        color: #555;
    }
    
    .orders-table tr:hover {
        background: #f8f9fa;
    }
    
    .status-ordered {
        background: #ffc107;
        color: #1a1a2e;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-delivered {
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-cancelled {
        background: #dc3545;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
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
    
    .no-orders h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    @media (max-width: 768px) {
        .orders-table {
            overflow-x: auto;
        }
        .orders-table table {
            min-width: 600px;
        }
    }
</style>

<section class="myorders-page">
    <div class="container">
        <div class="section-header">
            <h1>📋 My Orders</h1>
            <p>Track your order history and status</p>
        </div>
        
        <div class="orders-table">
            <?php 
            if($customer_email) {
                $sql = "SELECT * FROM tbl_order WHERE customer_email='$customer_email' ORDER BY id DESC";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                
                if($count > 0) {
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
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo $order['food']; ?></td>
                        <td><?php echo $order['qty']; ?></td>
                        <td>₹ <?php echo $order['total']; ?></td>
                        <td><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                        <td>
                            <?php
                            if($order['status'] == 'Ordered') {
                                echo '<span class="status-ordered">Ordered</span>';
                            } elseif($order['status'] == 'Delivered') {
                                echo '<span class="status-delivered">Delivered</span>';
                            } else {
                                echo '<span class="status-cancelled">Cancelled</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php 
                } else {
                    echo '<div class="no-orders">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>No Orders Yet</h3>
                            <p>You haven\'t placed any orders yet.</p>
                            <a href="'.SITEURL.'foods.php" class="btn-see-all">Browse Foods</a>
                          </div>';
                }
            } else {
                echo '<div class="no-orders">
                        <i class="fas fa-sign-in-alt"></i>
                        <h3>Login to View Orders</h3>
                        <p>Please login to see your order history.</p>
                        <a href="'.SITEURL.'login.php" class="btn-see-all">Login Now</a>
                      </div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>s