<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php 
            //CHeck whether id is set or not
            if(isset($_GET['id']))
            {
                //GEt the Order Details
                $id = $_GET['id'];

                //Get all other details based on this id
                //SQL Query to get the order details
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count Rows
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    //Detail Available
                    $row = mysqli_fetch_assoc($res);

                    // Get all values with isset() check
                    $food_id = isset($row['food_id']) ? $row['food_id'] : 0;
                    $price = isset($row['price']) ? $row['price'] : 0;
                    $qty = isset($row['qty']) ? $row['qty'] : 1;
                    $status = isset($row['status']) ? $row['status'] : 'Ordered';
                    $customer_name = isset($row['customer_name']) ? $row['customer_name'] : 'N/A';
                    $customer_contact = isset($row['customer_contact']) ? $row['customer_contact'] : 'N/A';
                    $customer_email = isset($row['customer_email']) ? $row['customer_email'] : 'N/A';
                    $customer_address = isset($row['customer_address']) ? $row['customer_address'] : 'N/A';
                    
                    // Get food name from tbl_food using food_id
                    $sql_food = "SELECT title FROM tbl_food WHERE id=$food_id";
                    $res_food = mysqli_query($conn, $sql_food);
                    if($res_food && mysqli_num_rows($res_food) > 0) {
                        $row_food = mysqli_fetch_assoc($res_food);
                        $food_name = $row_food['title'];
                    } else {
                        $food_name = "Food not found";
                    }
                }
                else
                {
                    //Detail not Available
                    //Redirect to Manage Order
                    $_SESSION['update'] = "<div class='error'>Order not found.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                    exit();
                }
            }
            else
            {
                //Redirect to Manage Order Page
                header('location:'.SITEURL.'admin/manage-order.php');
                exit();
            }
        ?>

        <form action="" method="POST">
        
            <table class="tbl-30">
                60
                    60<td>Food Name</td>
                    <td>
                        <b><?php echo $food_name; ?></b>
                        <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <b> ₹ <?php echo $price; ?></b>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="input-responsive" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" class="input-responsive" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Email</td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $customer_email; ?>" class="input-responsive" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Address</td>
                    <td>
                        <textarea name="customer_address" rows="3" class="input-responsive" required><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        
        </form>

        <?php 
            //CHeck whether Update Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //Get All the Values from Form
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $qty = mysqli_real_escape_string($conn, $_POST['qty']);
                $total = $price * $qty;
                $status = mysqli_real_escape_string($conn, $_POST['status']);
                $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
                $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
                $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
                $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
                
                //Update the Values
                $sql2 = "UPDATE tbl_order SET 
                    food_id = '$food_id',
                    qty = '$qty',
                    total = '$total',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //CHeck whether update or not
                if($res2 == true)
                {
                    //Updated
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                    exit();
                }
                else
                {
                    //Failed to Update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Order. Error: " . mysqli_error($conn) . "</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                    exit();
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>