<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
    header('location:index.php');
}
else {
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
    $currentTime = date( 'd-m-Y h:i:s A', time() );

    if(isset($_POST['submit']))
    {
        $category = $_POST['category'];
        $subcat = $_POST['subcategory'];
        $id = intval($_GET['id']);
        $sql = mysqli_query($con, "update subcategory set categoryid='$category',subcategory='$subcat',updationDate='$currentTime' where id='$id'");
        $_SESSION['msg'] = "Sub-Category Updated !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit SubCategory</title>
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
                <h2 class="fw-bold text-uppercase" style="letter-spacing: 1px;">EDIT SUB CATEGORY</h2>
            </div>

            <?php if(isset($_POST['submit'])) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlentities($_SESSION['msg']); unset($_SESSION['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="card mb-5">
                <div class="card-header">UPDATE SUB CATEGORY</div>
                <div class="card-body">
                    <form method="post">
                        <?php
                        $id = intval($_GET['id']);
                        $query = mysqli_query($con, "select category.id,category.categoryName,subcategory.subcategory from subcategory join category on category.id=subcategory.categoryid where subcategory.id='$id'");
                        while($row = mysqli_fetch_array($query)) {
                        ?>
                        <div class="mb-3">
                            <label for="category" class="form-label">CATEGORY</label>
                             <select name="category" id="category" class="form-select" style="font-size: 1rem; height: 48px;" required>
                                <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($catname=$row['categoryName']); ?></option>
                                <?php 
                                $ret = mysqli_query($con, "select * from category");
                                while($result = mysqli_fetch_array($ret)) {
                                    if($catname == $result['categoryName']) {
                                        continue;
                                    }
                                    ?>
                                    <option value="<?php echo $result['id']; ?>"><?php echo $result['categoryName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="subcategory" class="form-label">SUBCATEGORY NAME</label>
                           <input type="text" id="subcategory" name="subcategory" class="form-control" placeholder="ENTER SUBCATEGORY" style="font-size: 1rem; height: 48px;" required>
                        </div>

                        <?php } ?>

                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </form>
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
