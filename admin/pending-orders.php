<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Pending Orders</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>

    <script>
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin && !popUpWin.closed) popUpWin.close();
            popUpWin = open(URLStr, 'popUpWin', `toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=600,height=600,left=${left},top=${top}`);
        }
    </script>
</head>
<body>
<?php include('include/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">PENDING ORDERS</h2>
</div>


            <?php if(isset($_GET['del'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                    <?php $_SESSION['delmsg'] = ""; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email / Contact No</th>
                                <th>Shipping Address</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $status = 'Delivered';
                            $query = mysqli_query($con, "
                                SELECT 
                                    users.name AS username,
                                    users.email AS useremail,
                                    users.contactno AS usercontact,
                                    users.shippingAddress AS shippingaddress,
                                    users.shippingCity AS shippingcity,
                                    users.shippingState AS shippingstate,
                                    users.shippingPincode AS shippingpincode,
                                    products.productName AS productname,
                                    products.shippingCharge AS shippingcharge,
                                    orders.quantity AS quantity,
                                    orders.orderDate AS orderdate,
                                    products.productPrice AS productprice,
                                    orders.id AS id  
                                FROM orders 
                                JOIN users ON orders.userId = users.id 
                                JOIN products ON products.id = orders.productId 
                                WHERE orders.orderStatus != '$status' OR orders.orderStatus IS NULL
                            ");
                            $cnt = 1;
                            while($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($row['username']); ?></td>
                                <td><?php echo htmlentities($row['useremail']); ?>/<?php echo htmlentities($row['usercontact']); ?></td>
                                <td>
                                    <?php 
                                        echo htmlentities($row['shippingaddress']) . ", " .
                                             htmlentities($row['shippingcity']) . ", " .
                                             htmlentities($row['shippingstate']) . " - " .
                                             htmlentities($row['shippingpincode']);
                                    ?>
                                </td>
                                <td><?php echo htmlentities($row['productname']); ?></td>
                                <td><?php echo htmlentities($row['quantity']); ?></td>
                                <td>₱ <?php echo htmlentities($row['quantity'] * $row['productprice'] + $row['shippingcharge']); ?></td>
                                <td><?php echo htmlentities($row['orderdate']); ?></td>
                                <td>
                                    <a href="updateorder.php?oid=<?php echo htmlentities($row['id']); ?>" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $cnt++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php } ?>
