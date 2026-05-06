<?php include('partials/menu.php'); ?>
    <div class="wrapper">
        <h1>Manage Order</h1>
    </div>

                <br /><br /><br />

                <?php 
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>

                <table class="content-table">
                    58
                        <th>S.N.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Update Orders</th>
                    </tr>

                    <?php 
                        //Get all the orders from database
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Display the Latest Order at First
                        //Execute Query
                        $res = mysqli_query($conn, $sql);
                        //Count the Rows
                        $count = mysqli_num_rows($res);

                        $sn = 1; //Create a Serial Number and set its initail value as 1

                        if($count>0)
                        {
                            //Order Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //Get all the order details - with isset() check to avoid warnings
                                $id = isset($row['id']) ? $row['id'] : 0;
                                $food_id = isset($row['food_id']) ? $row['food_id'] : 0;
                                $price = isset($row['price']) ? $row['price'] : 0;
                                $qty = isset($row['qty']) ? $row['qty'] : 0;
                                $total = isset($row['total']) ? $row['total'] : 0;
                                $order_date = isset($row['order_date']) ? $row['order_date'] : 'N/A';
                                $status = isset($row['status']) ? $row['status'] : 'Ordered';
                                $customer_name = isset($row['customer_name']) ? $row['customer_name'] : 'N/A';
                                $customer_contact = isset($row['customer_contact']) ? $row['customer_contact'] : 'N/A';
                                $customer_email = isset($row['customer_email']) ? $row['customer_email'] : 'N/A';
                                $customer_address = isset($row['customer_address']) ? $row['customer_address'] : 'N/A';
                                
                                // Get food name from tbl_food
                                $sql2 = "SELECT title FROM tbl_food WHERE id=$food_id";
                                $res2 = mysqli_query($conn, $sql2);
                                if($res2 && mysqli_num_rows($res2) > 0) {
                                    $row2 = mysqli_fetch_assoc($res2);
                                    $food = $row2['title'];
                                } else {
                                    $food = "Food not found";
                                }
                                ?>

                                     <tr>
                                         <td><?php echo $sn++; ?>. </td>
                                         <td><?php echo $food; ?></td>
                                         <td>₹<?php echo $price; ?></td>
                                         <td><?php echo $qty; ?></td>
                                         <td>₹<?php echo $total; ?></td>
                                         <td><?php echo $order_date; ?></td>

                                         <td>
                                            <?php 
                                                // Ordered, On Delivery, Delivered, Cancelled
                                                if($status=="Ordered")
                                                {
                                                    echo "<label style='color: blue;'>$status</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: orange;'>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: green;'>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red;'>$status</label>";
                                                }
                                                else
                                                {
                                                    echo "<label>$status</label>";
                                                }
                                            ?>
                                         </td>

                                         <td><?php echo $customer_name; ?></td>
                                         <td><?php echo $customer_contact; ?></td>
                                         <td><?php echo $customer_email; ?></td>
                                         <td><?php echo $customer_address; ?></td>
                                         <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>"><img src="../images/icons/update.png"/></a>
                                         </td>
                                     </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //Order not Available
                            echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                        }
                    ?>

                 </table>

<?php include('partials/footer.php'); ?>