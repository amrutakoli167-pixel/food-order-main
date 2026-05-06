<?php 
session_start();
include('config/database.php'); 
include('partials-front/menu.php');

$error = '';
$success = '';

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // users टेबलमध्ये user आहे का ते check करा
    $sql = "SELECT * FROM users WHERE (username='$username' OR email='$username')";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    
    if($count == 1) {
        $row = mysqli_fetch_assoc($res);
        if(md5($password) == $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['full_name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['role'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        // नवीन user तयार करा
        $name = explode('@', $username)[0];
        $full_name = ucfirst($name);
        $email = (strpos($username, '@') !== false) ? $username : $name . '@example.com';
        $username_slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        
        $insert = "INSERT INTO users (full_name, username, email, password, role, created_at) 
                   VALUES ('$full_name', '$username_slug', '$email', MD5('$password'), 'user', NOW())";
        
        if(mysqli_query($conn, $insert)) {
            $new_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $new_id;
            $_SESSION['user_name'] = $full_name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'user';
            $success = "Account created successfully! Welcome to FoodHub!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<!-- Modern Login Page -->
<style>
    .login-page {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        overflow: hidden;
        max-width: 450px;
        width: 100%;
        animation: fadeInUp 0.6s ease;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
    }
    
    .login-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }
    
    .login-header p {
        margin: 10px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    
    .login-body {
        padding: 40px 30px;
    }
    
    .input-group {
        margin-bottom: 25px;
    }
    
    .input-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }
    
    .input-group input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s;
    }
    
    .input-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .demo-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
    }
    
    .demo-info p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }
    
    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    
    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border-left: 4px solid #16a34a;
    }
    
    .social-login {
        margin-top: 25px;
        text-align: center;
    }
    
    .social-login p {
        color: #666;
        font-size: 13px;
        margin-bottom: 15px;
        position: relative;
    }
    
    .social-login p:before,
    .social-login p:after {
        content: "";
        position: absolute;
        top: 50%;
        width: 30%;
        height: 1px;
        background: #e0e0e0;
    }
    
    .social-login p:before {
        left: 0;
    }
    
    .social-login p:after {
        right: 0;
    }
    
    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        text-decoration: none;
        color: white;
        font-size: 18px;
    }
    
    .social-icon.facebook {
        background: #3b5998;
    }
    
    .social-icon.twitter {
        background: #1da1f2;
    }
    
    .social-icon.instagram {
        background: #e4405f;
    }
    
    .social-icon.google {
        background: #db4437;
    }
    
    .social-icon:hover {
        transform: translateY(-3px);
        opacity: 0.9;
    }
    
    .register-link {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
    }
    
    .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }
    
    .register-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-page">
    <div class="login-card">
        <div class="login-header">
            <h2>🍽️ Welcome Back!</h2>
            <p>Login to continue your food journey</p>
        </div>
        
        <div class="login-body">
            <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="input-group">
                    <label>📧 Username or Email</label>
                    <input type="text" name="username" placeholder="Enter your email or username" required>
                </div>
                
                <div class="input-group">
                    <label>🔒 Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" name="login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login / Sign Up
                </button>
            </form>
            
            <div class="demo-info">
                <p>🔓 <strong>Demo Mode</strong> - Enter any email & password to login</p>
                <p>✨ New account will be created automatically!</p>
            </div>
            
            <div class="social-login">
                <p>Or continue with</p>
                <div class="social-icons">
                    <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon google"><i class="fab fa-google"></i></a>
                </div>
            </div>
            
            <div class="register-link">
                <p>Don't have an account? <a href="<?php echo SITEURL; ?>register.php">Create new account</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php include('partials-front/footer.php'); ?>