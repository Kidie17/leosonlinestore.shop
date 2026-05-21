<?php
session_start();
include('include/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $productname = $_POST['productName'];
        $productcompany = $_POST['productCompany'];
        $productprice = $_POST['productprice'];
        $productpricebd = $_POST['productpricebd'];
        $productdescription = $_POST['productDescription'];
        $productscharge = $_POST['productShippingcharge'];
        $productavailability = $_POST['productAvailability'];
        $productimage1 = $_FILES["productimage1"]["name"];
        $productimage2 = $_FILES["productimage2"]["name"];
        $productimage3 = $_FILES["productimage3"]["name"];

        $query = mysqli_query($con, "SELECT MAX(id) as pid FROM products");
        $result = mysqli_fetch_array($query);
        $productid = $result['pid'] + 1;
        $dir = "productimages/$productid";
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        move_uploaded_file($_FILES["productimage1"]["tmp_name"], "$dir/$productimage1");
        move_uploaded_file($_FILES["productimage2"]["tmp_name"], "$dir/$productimage2");
        move_uploaded_file($_FILES["productimage3"]["tmp_name"], "$dir/$productimage3");

        mysqli_query($con, "INSERT INTO products(category, subcategory, productName, productCompany, productPrice, productDescription, shippingCharge, productAvailability, productImage1, productImage2, productImage3, productPriceBeforeDiscount) 
        VALUES('$category','$subcat','$productname','$productcompany','$productprice','$productdescription','$productscharge','$productavailability','$productimage1','$productimage2','$productimage3','$productpricebd')");

        $_SESSION['msg'] = "Product Inserted Successfully!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Insert Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function getSubcat(val) {
            $.ajax({
                type: "POST",
                url: "get_subcat.php",
                data: 'cat_id=' + val,
                success: function (data) {
                    $("#subcategory").html(data);
                }
            });
        }
    </script>
</head>
<body>

<?php include('include/header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <?php include('include/sidebar.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="text-center fw-bold text-uppercase mb-4">Insert Product</h2>

            <!-- Alert Messages -->
            <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?php echo htmlentities($_SESSION['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php $_SESSION['msg'] = ""; ?>
            <?php } ?>

            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Add New Product</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" onChange="getSubcat(this.value);" required>
                                <option value="">Select Category</option>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM category");
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['categoryName'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subcategory</label>
                            <select name="subcategory" id="subcategory" class="form-select" required></select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="productName" class="form-control" placeholder="Enter Product Name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Company</label>
                            <input type="text" name="productCompany" class="form-control" placeholder="Enter Product Company" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price Before Discount</label>
                            <input type="text" name="productpricebd" class="form-control" placeholder="Enter Original Price" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Selling Price (After Discount)</label>
                            <input type="text" name="productprice" class="form-control" placeholder="Enter Selling Price" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Description</label>
                            <textarea name="productDescription" class="form-control" rows="5" placeholder="Enter description..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Charge</label>
                            <input type="text" name="productShippingcharge" class="form-control" placeholder="Enter Shipping Charge" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Availability</label>
                            <select name="productAvailability" class="form-select" required>
                                <option value="">Select</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image 1</label>
                            <input type="file" name="productimage1" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image 2</label>
                            <input type="file" name="productimage2" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Image 3</label>
                            <input type="file" name="productimage3" class="form-control">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Insert Product</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php } ?>
