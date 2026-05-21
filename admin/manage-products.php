<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
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
   		 <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">Manage Products</h2>
		</div>

            <?php if (isset($_GET['del'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
                    <?php $_SESSION['delmsg'] = ""; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-light fw-semibold">
                    Products List
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Company Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php 
                                $query = mysqli_query($con, "SELECT products.*, category.categoryName, subcategory.subcategory 
                                                          FROM products 
                                                          JOIN category ON category.id = products.category 
                                                          JOIN subcategory ON subcategory.id = products.subCategory");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($row['productName']); ?></td>
                                    <td><?php echo htmlentities($row['categoryName']); ?></td>
                                    <td><?php echo htmlentities($row['subcategory']); ?></td>
                                    <td><?php echo htmlentities($row['productCompany']); ?></td>
                                    <td><?php echo htmlentities($row['postingDate']); ?></td>
                                    <td>
                                        <a href="edit-products.php?id=<?php echo $row['id']; ?>" class="text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this product?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="manage-products.php?id=<?php echo $row['id']; ?>&del=delete" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
