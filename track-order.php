<?php
session_start();
include_once 'includes/config.php';
$oid = intval($_GET['oid']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Tracking Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .btn-custom {
            background-color: #0d6efd;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0b5ed7;
        }
    </style>

    <script>
        function closeWindow() {
            window.close();
        }

        function printPage() {
            window.print();
        }
    </script>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h3>Order Tracking Details</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Order ID:</strong> <?php echo $oid; ?>
            </div>

            <?php 
            $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
            $num = mysqli_num_rows($ret);
            if ($num > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <div class="mb-3">
                    <strong>At Date:</strong> <?php echo $row['postingDate']; ?>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> <?php echo $row['status']; ?>
                </div>
                <div class="mb-3">
                    <strong>Remark:</strong>
                    <div class="border p-2 bg-light"><?php echo $row['remark']; ?></div>
                </div>
                <hr>
            <?php 
                }
            } else {
            ?>
                <div class="alert alert-warning">
                    Order Not Processed Yet
                </div>
            <?php } ?>

            <?php
            $st = 'Delivered';
            $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
            while ($num = mysqli_fetch_array($rt)) {
                $currentSt = $num['orderStatus'];
            }
            if ($st == $currentSt) {
            ?>
                <div class="alert alert-success">
                    <strong>Product Delivered Successfully</strong>
                </div>
            <?php } ?>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-secondary me-2" onclick="closeWindow()">Close</button>
            <button class="btn btn-custom" onclick="printPage()">Print</button>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
