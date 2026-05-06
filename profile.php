<?php 
session_start();
include('config/database.php'); 
include('partials-front/menu.php');

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Get user details from database
$sql = "SELECT * FROM users WHERE id='$user_id'";
$res = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($res);

// Update profile
if(isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $update = "UPDATE users SET full_name='$full_name', username='$username', email='$email', contact='$contact', address='$address' WHERE id='$user_id'";
    
    if(mysqli_query($conn, $update)) {
        $_SESSION['user_name'] = $full_name;
        $_SESSION['user_email'] = $email;
        $success = "Profile updated successfully!";
        // Refresh user data
        $res = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
        $user = mysqli_fetch_assoc($res);
    } else {
        $error = "Failed to update profile.";
    }
}

// Change password
if(isset($_POST['change_password'])) {
    $current = md5(mysqli_real_escape_string($conn, $_POST['current_password']));
    $new = md5(mysqli_real_escape_string($conn, $_POST['new_password']));
    $confirm = md5(mysqli_real_escape_string($conn, $_POST['confirm_password']));
    
    if($current != $user['password']) {
        $pwd_error = "Current password is incorrect!";
    } elseif($new != $confirm) {
        $pwd_error = "New passwords do not match!";
    } else {
        $update = "UPDATE users SET password='$new' WHERE id='$user_id'";
        if(mysqli_query($conn, $update)) {
            $pwd_success = "Password changed successfully!";
        } else {
            $pwd_error = "Failed to change password.";
        }
    }
}
?>

<style>
    .profile-page {
        background: #f8f9fa;
        padding: 80px 0;
        min-height: 80vh;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .profile-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .profile-header h1 {
        font-size: 42px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
    }
    
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .profile-card h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #1a1a2e;
        border-left: 4px solid #ff6b6b;
        padding-left: 15px;
    }
    
    .user-avatar-large {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .avatar-circle {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 48px;
        font-weight: 600;
    }
    
    .input-group {
        margin-bottom: 20px;
    }
    
    .input-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
    }
    
    .input-group input,
    .input-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
    }
    
    .input-group input:focus,
    .input-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }
    
    .btn-save {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102,126,234,0.3);
    }
    
    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border-left: 4px solid #16a34a;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    
    .info-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .info-label {
        width: 120px;
        font-weight: 600;
        color: #666;
    }
    
    .info-value {
        flex: 1;
        color: #333;
    }
    
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .profile-header h1 {
            font-size: 32px;
        }
    }
</style>

<section class="profile-page">
    <div class="container">
        <div class="profile-header">
            <h1><i class="fas fa-user-circle"></i> My Profile</h1>
            <p>Manage your account details</p>
        </div>
        
        <div class="profile-grid">
            <!-- Profile Info Card -->
            <div class="profile-card">
                <h2><i class="fas fa-user"></i> Profile Information</h2>
                
                <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="user-avatar-large">
                    <div class="avatar-circle">
                        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                    </div>
                </div>
                
                <form method="POST">
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Phone Number</label>
                        <input type="text" name="contact" value="<?php echo isset($user['contact']) ? $user['contact'] : ''; ?>">
                    </div>
                    
                    <div class="input-group">
                        <label>Delivery Address</label>
                        <textarea name="address" rows="3"><?php echo isset($user['address']) ? $user['address'] : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>
            
            <!-- Change Password Card -->
            <div class="profile-card">
                <h2><i class="fas fa-lock"></i> Change Password</h2>
                
                <?php if(isset($pwd_success)): ?>
                    <div class="alert alert-success"><?php echo $pwd_success; ?></div>
                <?php endif; ?>
                
                <?php if(isset($pwd_error)): ?>
                    <div class="alert alert-error"><?php echo $pwd_error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="input-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="Enter current password" required>
                    </div>
                    
                    <div class="input-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="Enter new password" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                    </div>
                    
                    <button type="submit" name="change_password" class="btn-save">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>
                
                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <h3 style="font-size: 16px; margin-bottom: 15px;">Account Summary</h3>
                    <div class="info-row">
                        <div class="info-label">Member Since</div>
                        <div class="info-value"><?php echo isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'Recently'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Account Type</div>
                        <div class="info-value"><?php echo isset($user['role']) ? ucfirst($user['role']) : 'User'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>