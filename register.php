<?php 
session_start();
include('config/database.php'); 

if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if(isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $contact = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));
    
    // Check if username exists
    $check_username = "SELECT * FROM users WHERE username='$username'";
    $check_res = mysqli_query($conn, $check_username);
    
    // Check if email exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $email_res = mysqli_query($conn, $check_email);
    
    if(mysqli_num_rows($check_res) > 0){
        $error = "Username already exists!";
    } elseif(mysqli_num_rows($email_res) > 0) {
        $error = "Email already registered!";
    } elseif($password != $confirm) {
        $error = "Passwords do not match!";
    } else {
        $sql = "INSERT INTO users (full_name, username, email, contact, address, password, role, created_at) 
                VALUES ('$full_name', '$username', '$email', '$contact', '$address', MD5('$password'), 'user', NOW())";
        
        if(mysqli_query($conn, $sql)){
            $success = "Registration successful! Redirecting to login...";
            // 👇 हा बदल केला - 2 सेकंदात login page वर redirect
            header("refresh:2; url=login.php");
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FoodHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255,255,255,0.95);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .container-nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo a {
            font-size: 28px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .logo i {
            margin-right: 5px;
            color: #ff6b6b;
        }

        .clearfix {
            clear: both;
        }

        /* Register Form Styles */
        .register-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 150px);
            padding: 40px 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 550px;
            max-width: 100%;
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .register-header i {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 600;
        }

        .register-header p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .register-body {
            padding: 35px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 16px;
            z-index: 1;
        }

        .input-group textarea ~ i {
            top: 22px;
            transform: none;
        }

        .input-group input, .input-group textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .input-group textarea {
            padding-top: 12px;
            resize: vertical;
            min-height: 80px;
        }

        .input-group input:focus, .input-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }

        .row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .register-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border-left: 3px solid #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .success-message {
            background: #dcfce7;
            color: #16a34a;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border-left: 3px solid #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .login-link p {
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }

        .terms a {
            color: #667eea;
            text-decoration: none;
        }

        /* Footer */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 480px) {
            .register-body {
                padding: 25px;
            }
            .register-header {
                padding: 25px;
            }
            .row-2col {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<section class="navbar">
    <div class="container-nav">
        <div class="logo">
            <a href="index.php">
                <i class="fas fa-utensils"></i> FoodHub
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
</section>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Create Account</h2>
            <p>Join FoodHub to order delicious food</p>
        </div>
        
        <div class="register-body">
            <?php if(!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($success)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="full_name" placeholder="Full Name" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-at"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="row-2col">
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="contact" placeholder="Phone Number">
                    </div>
                    
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="address" placeholder="Delivery Address">
                    </div>
                </div>
                
                <div class="row-2col">
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <div class="input-group">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                </div>
                
                <button type="submit" name="register" class="register-btn">
                    <i class="fas fa-user-plus"></i> Sign Up
                </button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
            
            <div class="terms">
                By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<section class="footer">
    <div class="container">
        <div class="text-center">
            <p>All rights reserved. Designed with ❤️ by FoodHub</p>
        </div>
    </div>
</section>

</body>
</html>