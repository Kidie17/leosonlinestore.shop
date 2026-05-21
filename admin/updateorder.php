<?php
session_start();
include_once 'include/config.php';
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $oid = intval($_GET['oid']);
    if (isset($_POST['submit2'])) {
        $status = $_POST['status'];

       if ($status == 'in Process') {

            $order = mysqli_query($con, "SELECT * FROM orders WHERE id = " . $_GET['oid']);
            $currentOrder = mysqli_fetch_assoc($order);

            $qty = $currentOrder['quantity'];
            $productId = $currentOrder['productId'];

            // ✅ Reduce stock of the specific product
            mysqli_query($con, "
                UPDATE products 
                SET stock = stock - $qty 
                WHERE id = $productId
            ");
        }

        $remark = $_POST['remark'];

        $query = mysqli_query($con, "INSERT INTO ordertrackhistory(orderId, status, remark) VALUES('$oid', '$status', '$remark')");
        $sql = mysqli_query($con, "UPDATE orders SET orderStatus='$status' WHERE id='$oid'");
        echo "<script>alert('Order updated successfully...');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 900px;
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .form-label {
            font-weight: bold;
        }
        textarea {
            resize: none;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <a href="todays-orders.php" style="color:white; font-size : 20px;">Go Back</a>
            <h3>UPDATE ORDER</h3>
        </div>
        <div class="card-body">
            <form name="updateticket" id="updateticket" method="post">
                <div class="mb-3">
                    <label for="orderId" class="form-label">Order ID:</label>
                    <input type="text" class="form-control" id="orderId" value="<?php echo $oid; ?>" readonly>
                </div>
                <?php 
                $ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
                while ($row = mysqli_fetch_array($ret)) { 
                ?>
                    <div class="mb-3">
                        <label class="form-label">At Date:</label>
                        <input type="text" class="form-control" value="<?php echo $row['postingDate']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <input type="text" class="form-control" value="<?php echo $row['status']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remark:</label>
                        <textarea class="form-control" rows="4" readonly><?php echo $row['remark']; ?></textarea>
                    </div>
                    <hr>
                <?php } ?>
                
                <?php 
                $st = 'Delivered';
                $rt = mysqli_query($con, "SELECT * FROM orders WHERE id='$oid'");
                while ($num = mysqli_fetch_array($rt)) {
                    $currentSt = $num['orderStatus'];
                }
                if ($st == $currentSt) { ?>
                    <div class="alert alert-success" role="alert">
                        <strong>PRODUCT DELIVERED</strong>
                    </div>
                <?php } else { ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="in Process">In Process</option>
                            <option value="Packed">Packed</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark:</label>
                        <textarea name="remark" id="remark" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="submit2" class="btn btn-custom">Update</button>
                        <button type="button" class="btn btn-secondary" onClick="window.close()">Close</button>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
