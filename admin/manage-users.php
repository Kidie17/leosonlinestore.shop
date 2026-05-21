<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_GET['del'])) {
        mysqli_query($con, "DELETE FROM products WHERE id = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "Product deleted!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Manage Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(76, 75, 75, 0.06);
    }
    .table thead th {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid py-0">
  <div class="row">
    <?php include('include/sidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">MANAGE USER</h2>
</div>


      <?php if (isset($_GET['del'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Deleted!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
          <?php $_SESSION['delmsg'] = ""; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header bg-light fw-semibold">
          Registered Users
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0">
              <thead class="table-dark text-center">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact No.</th>
                  <th>Shipping Address</th>
                  <th>Billing Address</th>
                  <th>Registered On</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <?php 
                $query = mysqli_query($con, "SELECT * FROM users");
                $cnt = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                  <td><?php echo htmlentities($cnt); ?></td>
                  <td><?php echo htmlentities($row['name']); ?></td>
                  <td><?php echo htmlentities($row['email']); ?></td>
                  <td><?php echo htmlentities($row['contactno']); ?></td>
                  <td><?php echo htmlentities($row['shippingAddress'] . ', ' . $row['shippingCity'] . ', ' . $row['shippingState'] . ' - ' . $row['shippingPincode']); ?></td>
                  <td><?php echo htmlentities($row['billingAddress'] . ', ' . $row['billingCity'] . ', ' . $row['billingState'] . ' - ' . $row['billingPincode']); ?></td>
                  <td><?php echo htmlentities($row['regDate']); ?></td>
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
</body>
</html>
<?php } ?>
