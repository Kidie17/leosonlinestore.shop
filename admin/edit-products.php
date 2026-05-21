<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
    $pid=intval($_GET['id']);

    if(isset($_POST['submit'])) {
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $productname = $_POST['productName'];
        $productcompany = $_POST['productCompany'];
        $productprice = $_POST['productprice'];
        $productpricebd = $_POST['productpricebd'];
        $productdescription = $_POST['productDescription'];
        $productscharge = $_POST['productShippingcharge'];
        $productavailability = $_POST['productAvailability'];

        $sql = mysqli_query($con,"UPDATE products SET category='$category', subCategory='$subcat', productName='$productname', productCompany='$productcompany', productPrice='$productprice', productDescription='$productdescription', shippingCharge='$productscharge', productAvailability='$productavailability', productPriceBeforeDiscount='$productpricebd' WHERE id='$pid'");
        $_SESSION['msg'] = "Product Updated Successfully !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http://js.nicedit.com/nicEdit-latest.js"></script>
    <script>bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    <script>
        function getSubcat(val) {
            $.post("get_subcat.php", { cat_id: val }, function(data){
                $("#subcategory").html(data);
            });
        }
    </script>
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="text-center my-4">
    <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">EDIT PRODUCTS</h2>
</div>

            <?php if(isset($_POST['submit'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?= htmlentities($_SESSION['msg']); ?>
                    <?php $_SESSION['msg'] = ""; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php 
                        $query = mysqli_query($con, "SELECT products.*, category.categoryName AS catname, category.id AS cid, subcategory.subcategory AS subcatname, subcategory.id AS subcatid 
                            FROM products 
                            JOIN category ON category.id = products.category 
                            JOIN subcategory ON subcategory.id = products.subCategory 
                            WHERE products.id='$pid'");
                        while($row = mysqli_fetch_array($query)):
                        ?>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" onchange="getSubcat(this.value);" required>
                                <option value="<?= $row['cid'] ?>"><?= $row['catname'] ?></option>
                                <?php 
                                $catQuery = mysqli_query($con, "SELECT * FROM category");
                                while($rw = mysqli_fetch_array($catQuery)) {
                                    if ($row['catname'] != $rw['categoryName']) {
                                        echo "<option value='{$rw['id']}'>{$rw['categoryName']}</option>";
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub Category</label>
                            <select name="subcategory" id="subcategory" class="form-select" required>
                                <option value="<?= $row['subcatid'] ?>"><?= $row['subcatname'] ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="productName" value="<?= $row['productName'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Company</label>
                            <input type="text" name="productCompany" value="<?= $row['productCompany'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Before Discount</label>
                            <input type="number" name="productpricebd" value="<?= $row['productPriceBeforeDiscount'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price After Discount</label>
                            <input type="number" name="productprice" value="<?= $row['productPrice'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Description</label>
                            <textarea name="productDescription" class="form-control" rows="5"><?= $row['productDescription'] ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Charge</label>
                            <input type="text" name="productShippingcharge" value="<?= $row['shippingCharge'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Availability</label>
                            <select name="productAvailability" class="form-select" required>
                                <option value="<?= $row['productAvailability'] ?>"><?= $row['productAvailability'] ?></option>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>

                        <!-- Image Previews -->
                        <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="mb-3">
                                <label class="form-label">Product Image <?= $i ?></label><br>
                                <img src="productimages/<?= $pid ?>/<?= htmlentities($row["productImage$i"]) ?>" width="200" class="img-thumbnail mb-2">
                                <br>
                                <a href="update-image<?= $i ?>.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Change Image</a>
                            </div>
                        <?php endfor; ?>

                        <div class="text-end">
                            <button type="submit" name="submit" class="btn btn-success">Update Product</button>
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
