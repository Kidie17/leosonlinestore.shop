<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        mysqli_query($con, "INSERT INTO category(categoryName,categoryDescription) VALUES('$category','$description')");
        $_SESSION['msg'] = "Category Created !!";
    }

    if (isset($_GET['del'])) {
        mysqli_query($con, "DELETE FROM category WHERE id = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "Category Deleted !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Categories</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">CREATE CATEGORY</h2>
</div>


            <!-- Alert Messages -->
<?php if (isset($_POST['submit'])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php $_SESSION['msg'] = ""; ?>
<?php } ?>

<?php if (isset($_GET['del'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Deleted!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php $_SESSION['delmsg'] = ""; ?>
<?php } ?>


            <!-- Create Category Form -->
            <div class="card mb-4">
                <div class="card-header fw-semibold">Create New Category</div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category" id="category" placeholder="Enter category name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter description..."></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="card">
                <div class="card-header fw-semibold">Category List</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $query = mysqli_query($con, "SELECT * FROM category");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($row['categoryName']); ?></td>
                                <td><?php echo htmlentities($row['categoryDescription']); ?></td>
                                <td><?php echo htmlentities($row['creationDate']); ?></td>
                                <td><?php echo htmlentities($row['updationDate']); ?></td>
                                <td>
                                    <a href="edit-category.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-outline-info me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="category.php?id=<?php echo $row['id'] ?>&del=delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
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

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php } ?>
</body>
</html>
