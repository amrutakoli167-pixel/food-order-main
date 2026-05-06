<?php 
session_start();
include('../config/constants.php');

if(isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}

$login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
    
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    
    if($count == 1){
        $_SESSION['user'] = $username;
        header('location: index.php');
        exit;
    } else {
        $login_err = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            width: 400px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25);
            text-align: center;
        }
        .login-container img {
            width: 120px;
            margin-bottom: 20px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="../images/logo.png" alt="Logo">
        <h2>Admin Login</h2>
        <?php if(!empty($login_err)) echo '<div class="error">'.$login_err.'</div>'; ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>