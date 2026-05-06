<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add User</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            // Show any errors if occurred
            if(isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Full Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>
                        <input type="email" name="email" placeholder="Enter Email">
                    </td>
                </tr>

                <tr>
                    <td>Contact: </td>
                    <td>
                        <input type="text" name="contact" placeholder="Enter Contact Number">
                    </td>
                </tr>

                <tr>
                    <td>Address: </td>
                    <td>
                        <textarea name="address" placeholder="Enter Address" rows="3"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add User" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])) {
                // Get data from form with default values if empty
                $full_name = !empty($_POST['full_name']) ? mysqli_real_escape_string($conn, $_POST['full_name']) : 'Unknown';
                $username = !empty($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : 'user_' . rand(1000, 9999);
                $email = !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : 'noemail@example.com';
                $contact = !empty($_POST['contact']) ? mysqli_real_escape_string($conn, $_POST['contact']) : '0000000000';
                $address = !empty($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : 'Not Provided';
                $password = !empty($_POST['password']) ? md5($_POST['password']) : md5('default123');
                
                // First check which columns exist in users table
                $columns_query = "SHOW COLUMNS FROM users";
                $columns_result = mysqli_query($conn, $columns_query);
                $existing_columns = [];
                
                while($column = mysqli_fetch_assoc($columns_result)) {
                    $existing_columns[] = $column['Field'];
                }
                
                // Build dynamic SQL query based on existing columns
                $insert_fields = [];
                $insert_values = [];
                
                // Map form fields to possible database column names
                $field_mappings = [
                    'full_name' => ['full_name', 'customer_name', 'name'],
                    'username' => ['username', 'user_name', 'uname'],
                    'email' => ['email', 'customer_email', 'user_email', 'mail'],
                    'contact' => ['contact', 'customer_contact', 'phone', 'mobile'],
                    'address' => ['address', 'customer_address', 'addr'],
                    'password' => ['password', 'pass', 'pwd']
                ];
                
                $values = [
                    'full_name' => $full_name,
                    'username' => $username,
                    'email' => $email,
                    'contact' => $contact,
                    'address' => $address,
                    'password' => $password
                ];
                
                // Find matching columns in database
                foreach($field_mappings as $field => $possible_names) {
                    foreach($possible_names as $col_name) {
                        if(in_array($col_name, $existing_columns)) {
                            $insert_fields[] = $col_name;
                            $insert_values[] = "'" . $values[$field] . "'";
                            break;
                        }
                    }
                }
                
                // Always include id if it exists (auto-increment)
                if(in_array('id', $existing_columns)) {
                    // id is auto_increment, so don't insert it
                }
                
                // Create and execute query if we have fields to insert
                if(!empty($insert_fields)) {
                    $sql = "INSERT INTO users (" . implode(', ', $insert_fields) . ") 
                            VALUES (" . implode(', ', $insert_values) . ")";
                    
                    // For debugging - remove after testing
                    // echo $sql;
                    
                    $res = mysqli_query($conn, $sql);
                    
                    if($res == TRUE) {
                        $_SESSION['add'] = "<div class='success'>User Added Successfully</div>";
                        header('location: manage-users.php');
                        exit();
                    } else {
                        $error = mysqli_error($conn);
                        $_SESSION['error'] = "<div class='error'>Failed to Add User: $error</div>";
                        header('location: add-users.php');
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "<div class='error'>No matching columns found in database</div>";
                    header('location: add-users.php');
                    exit();
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>