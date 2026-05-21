<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Create subcategory
if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $subcat = $_POST['subcategory'];
    mysqli_query($con, "INSERT INTO subcategory(categoryid, subcategory) VALUES('$category', '$subcat')");
    $_SESSION['msg'] = "Subcategory Created Successfully!";
    header("Location: subcategory.php");
    exit();
}

// Delete subcategory
if (isset($_GET['del']) && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Use intval to sanitize
    mysqli_query($con, "DELETE FROM subcategory WHERE id = '$id'");
    $_SESSION['delmsg'] = "Subcategory deleted successfully!";
    header("Location: subcategory.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Sub Category</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="images/icons/css/font-awesome.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }
        h2 {
            font-weight: 700;
            color: #0d6efd;
        }
        label.form-label {
            font-weight: 600;
            font-size: 1rem;
        }
        .form-select, .form-control {
            font-size: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }
        .btn-primary {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
        }
        .card-header {
            font-weight: 600;
            font-size: 1.1rem;
            background-color: #e8f1ff;
            color: #0d6efd;
        }
        table th {
            background-color: #0d6efd;
            color: white;
            vertical-align: middle;
        }
        table td {
            vertical-align: middle;
        }
        .table td a {
            font-size: 1.1rem;
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
                <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">SUB CATEGORY</h2>
            </div>
			
			<!-- Alert Messages -->
	<?php if (!empty($_SESSION['msg'])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo htmlentities($_SESSION['msg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php $_SESSION['msg'] = ""; ?>
<?php } ?>

<?php if (!empty($_SESSION['delmsg'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-trash-alt me-2"></i>
        <?php echo htmlentities($_SESSION['delmsg']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php $_SESSION['delmsg'] = ""; ?>
<?php } ?>


            <!-- Subcategory Creation Form -->
            <div class="card mb-5">
                <div class="card-header">CREATE SUB CATEGORY</div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="category" class="form-label">CATEGORY</label>
                            <select name="category" id="category" class="form-select" style="font-size: 1rem; height: 48px;" required>
                                <option value="">SELECT CATEGORY</option>
                                <?php 
                                $query = mysqli_query($con, "SELECT * FROM category");
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['categoryName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="subcategory" class="form-label">CREATE SUBCATEGORY</label>
                            <input type="text" id="subcategory" name="subcategory" class="form-control" placeholder="ENTER SUBCATEGORY" style="font-size: 1rem; height: 48px;" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>

            <!-- Subcategory Management Table -->
            <div class="card">
                <div class="card-header">MANAGE SUB CATEGORIES</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CATEGORY</th>
                                    <th>SUB CATEGORY</th>
                                    <th>CREATION DATE</th>
                                    <th>LAST UPDATED</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $query = mysqli_query($con, "SELECT subcategory.id, category.categoryName, subcategory.subcategory, subcategory.creationDate, subcategory.updationDate FROM subcategory JOIN category ON category.id = subcategory.categoryid");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo htmlentities($cnt); ?></td>
                                    <td><?php echo htmlentities($row['categoryName']); ?></td>
                                    <td><?php echo htmlentities($row['subcategory']); ?></td>
                                    <td><?php echo htmlentities($row['creationDate']); ?></td>
                                    <td><?php echo htmlentities($row['updationDate']); ?></td>
                                    <td>
                                        <a href="edit-subcategory.php?id=<?php echo $row['id']; ?>" class="text-primary me-2"><i class="fa fa-edit"></i></a>
                                        <a href="subcategory.php?id=<?php echo $row['id']; ?>&del=delete" class="text-danger" onClick="return confirm('Are you sure you want to delete this subcategory?')"><i class="fa fa-trash"></i></a>
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
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
