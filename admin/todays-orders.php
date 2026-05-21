<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {	
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
    <title>Admin | Todays Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(255, 251, 251, 0.1);
        }
        .table-responsive {
            margin-top: 0px;
        }
    </style>
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid mt-0">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
            <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Today's Order</h2>
</div>

                <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">

                    <?php if (isset($_GET['del'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                            <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <div class="table-responsive">
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
                                $from = date('Y-m-d') . " 00:00:00";
                                $to = date('Y-m-d') . " 23:59:59";
                                $query = mysqli_query($con, "SELECT users.name AS username, users.email AS useremail, users.contactno AS usercontact,
                                    users.shippingAddress AS shippingaddress, users.shippingCity AS shippingcity,
                                    users.shippingState AS shippingstate, users.shippingPincode AS shippingpincode,
                                    products.productName AS productname, products.shippingCharge AS shippingcharge,
                                    orders.quantity AS quantity, orders.orderDate AS orderdate,
                                    products.productPrice AS productprice, orders.id AS id
                                    FROM orders
                                    JOIN users ON orders.userId = users.id
                                    JOIN products ON products.id = orders.productId
                                    WHERE orders.orderDate BETWEEN '$from' AND '$to'");

                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                    $totalAmount = $row['quantity'] * $row['productprice'] + $row['shippingcharge'];
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($row['username']); ?></td>
                                    <td><?php echo htmlentities($row['useremail']) . " / " . htmlentities($row['usercontact']); ?></td>
                                    <td><?php echo htmlentities($row['shippingaddress'] . ", " . $row['shippingcity'] . ", " . $row['shippingstate'] . " - " . $row['shippingpincode']); ?></td>
                                    <td><?php echo htmlentities($row['productname']); ?></td>
                                    <td><?php echo htmlentities($row['quantity']); ?></td>
                                    <td>₱ <?php echo number_format($totalAmount, 2); ?></td>
                                    <td><?php echo htmlentities($row['orderdate']); ?></td>
                                    <td>
                                        <a href="updateorder.php?oid=<?php echo htmlentities($row['id']); ?>" title="Update order" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $cnt++; } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php } ?>
