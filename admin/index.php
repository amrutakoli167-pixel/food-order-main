<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>

        <?php 
            $sql_cat = "SELECT * FROM tbl_category";
            $res_cat = mysqli_query($conn, $sql_cat);
            $count_cat = mysqli_num_rows($res_cat);

            $sql_food = "SELECT * FROM tbl_food";
            $res_food = mysqli_query($conn, $sql_food);
            $count_food = mysqli_num_rows($res_food);

            $sql_order = "SELECT * FROM tbl_order";
            $res_order = mysqli_query($conn, $sql_order);
            $count_order = mysqli_num_rows($res_order);

            $sql_user = "SELECT * FROM users";
            $res_user = mysqli_query($conn, $sql_user);
            $count_user = mysqli_num_rows($res_user);

            $sql_revenue = "SELECT SUM(total) AS total FROM tbl_order WHERE status='Delivered'";
            $res_revenue = mysqli_query($conn, $sql_revenue);
            $row_revenue = mysqli_fetch_assoc($res_revenue);
            $total_revenue = $row_revenue['total'] ?? 0;
        ?>

        <div class="col-4 text-center">
            <h1><?php echo $count_cat; ?></h1>
            <br />Categories
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $count_food; ?></h1>
            <br />Foods
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $count_order; ?></h1>
            <br />Total Orders
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $count_user; ?></h1>
            <br />Total Users
        </div>

        <div class="col-4 text-center">
            <h1>₹<?php echo $total_revenue; ?></h1>
            <br />Revenue Generated
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<?php include('partials/footer.php'); ?>