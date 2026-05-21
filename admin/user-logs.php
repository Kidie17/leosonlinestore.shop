<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | User Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">USER LOGS</h2>
</div>


            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title">Manage User Logs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>User Email</th>
                                    <th>User IP</th>
                                    <th>Login Time</th>
                                    <th>Logout Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM userlog");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row['userEmail']); ?></td>
                                        <td><?php echo htmlentities($row['userip']); ?></td>
                                        <td><?php echo htmlentities($row['loginTime']); ?></td>
                                        <td><?php echo htmlentities($row['logout']); ?></td>
                                        <td>
                                            <?php
                                            $status = $row['status'];
                                            if ($status == 1) {
                                                echo '<span class="badge bg-success">Successful</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">Failed</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php 
                                    $cnt++;
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="fas fa-chevron-left"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="fas fa-chevron-right"></i>');
    });
</script>

</body>
<?php } ?>
</html>
