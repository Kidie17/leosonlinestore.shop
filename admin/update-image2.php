<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $pid = intval($_GET['id']);

    if (isset($_POST['submit'])) {
        $productname = $_POST['productName'];
        $productimage2 = $_FILES["productimage2"]["name"];

        move_uploaded_file($_FILES["productimage2"]["tmp_name"], "productimages/$pid/" . $productimage2);
        $sql = mysqli_query($con, "UPDATE products SET productImage2='$productimage2' WHERE id='$pid'");
        $_SESSION['msg'] = "Product Image Updated Successfully !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product Image 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('include/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include('include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
             <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">UPDATE PRODUCT IMAGE 2</h2>
</div>

            <?php if(isset($_POST['submit'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlentities($_SESSION['msg']); ?>
                    <?php $_SESSION['msg'] = ""; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php 
                        $query = mysqli_query($con, "SELECT productName, productImage2 FROM products WHERE id='$pid'");
                        while($row = mysqli_fetch_array($query)):
                        ?>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" value="<?= htmlentities($row['productName']) ?>" readonly name="productName">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Product Image</label><br>
                            <img src="productimages/<?= $pid ?>/<?= htmlentities($row['productImage2']) ?>" width="250" class="img-thumbnail">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Product Image</label>
                            <input type="file" class="form-control" name="productimage2" required>
                        </div>

                        <div class="text-end">
                            <button type="submit" name="submit" class="btn btn-primary">Update Image</button>
                        </div>

                        <?php endwhile; ?>
                    </form>
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
