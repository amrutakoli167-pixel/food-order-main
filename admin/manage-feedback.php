<?php 
session_start();
include('../config/database.php');

// Admin check - तात्पुरते remove केलं (पहिल्यांदा access साठी)
// if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
//     header("Location: ../login.php");
//     exit();
// }

// Approve feedback
if(isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $update = "UPDATE feedback SET status='approved' WHERE id='$id'";
    mysqli_query($conn, $update);
    header("Location: manage-feedback.php");
    exit();
}

// Delete feedback
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM feedback WHERE id='$id'";
    mysqli_query($conn, $delete);
    header("Location: manage-feedback.php");
    exit();
}

// Get all feedback
$pending = mysqli_query($conn, "SELECT * FROM feedback WHERE status='pending' ORDER BY created_at DESC");
$approved = mysqli_query($conn, "SELECT * FROM feedback WHERE status='approved' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Feedback - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        h1 { margin-bottom: 30px; color: #333; }
        .section { background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .section h2 { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #ff6b6b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #333; }
        .rating-stars { color: #ffc107; }
        .btn-approve { background: #28a745; color: white; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; display: inline-block; }
        .btn-delete { background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-left: 5px; display: inline-block; }
        .feedback-message { max-width: 300px; word-wrap: break-word; }
        .back-link { display: inline-block; margin-top: 20px; color: #667eea; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-comment"></i> Manage Feedback</h1>
        
        <!-- Pending Feedback -->
        <div class="section">
            <h2>⏳ Pending Feedback</h2>
            <table>
                <thead>
                    <tr><th>User</th><th>Rating</th><th>Feedback</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($pending) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($pending)): ?>
                        <tr>
                            <td><strong><?php echo $row['user_name']; ?></strong><br><small><?php echo $row['user_email']; ?></small></td>
                            <td class="rating-stars"><?php for($i=1;$i<=5;$i++){ echo $i<=$row['rating'] ? '★' : '☆'; } ?></td>
                            <td class="feedback-message"><?php echo substr($row['message'], 0, 100); ?>...</td>
                            <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="?approve=<?php echo $row['id']; ?>" class="btn-approve"><i class="fas fa-check"></i> Approve</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this feedback?')"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No pending feedback</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Approved Feedback -->
        <div class="section">
            <h2>✅ Approved Feedback</h2>
            <table>
                <thead>
                    <tr><th>User</th><th>Rating</th><th>Feedback</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($approved) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($approved)): ?>
                        <tr>
                            <td><strong><?php echo $row['user_name']; ?></strong><br><small><?php echo $row['user_email']; ?></small></td>
                            <td class="rating-stars"><?php for($i=1;$i<=5;$i++){ echo $i<=$row['rating'] ? '★' : '☆'; } ?></td>
                            <td class="feedback-message"><?php echo substr($row['message'], 0, 100); ?>...</td>
                            <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td><a href="?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this feedback?')"><i class="fas fa-trash"></i> Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No approved feedback</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <a href="../index.php" class="back-link">← Back to Home</a>
    </div>
</body>
</html>