<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // Set the timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $id = intval($_GET['id']);
        $sql = mysqli_query($con, "UPDATE category SET categoryName='$category', categoryDescription='$description', updationDate='$currentTime' WHERE id='$id'");
        $_SESSION['msg'] = "Category Updated !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Update Category</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid mt-0">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="text-center my-4">
                <h2 class="fw-bold text-uppercase">Update Category</h2>
            </div>

            <!-- Success Message -->
            <?php if(isset($_POST['submit'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php $_SESSION['msg'] = ""; ?>
            <?php } ?>

            <!-- Category Update Form -->
            <div class="card mb-4">
                <div class="card-header fw-semibold">Update Category Details</div>
                <div class="card-body">
                    <form method="post">
                        <?php
                        $id = intval($_GET['id']);
                        $query = mysqli_query($con, "SELECT * FROM category WHERE id='$id'");
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlentities($row['categoryName']); ?>" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter description..." required><?php echo htmlentities($row['categoryDescription']); ?></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php } ?>
