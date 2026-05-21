<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $oldPassword = md5($_POST['password']);
        $newPassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];

        $sql = mysqli_query($con, "SELECT password FROM admin WHERE password='$oldPassword' AND username='$username'");
        if (mysqli_num_rows($sql) > 0) {
            mysqli_query($con, "UPDATE admin SET password='$newPassword', updationDate='$currentTime' WHERE username='$username'");
            $_SESSION['msg'] = "success:Password changed successfully!";
        } else {
            $_SESSION['msg'] = "error:Old password does not match!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-uppercase text-dark">Change Password</h2>
            </div>

            <!-- Alert Message -->
            <?php
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") {
                list($type, $message) = explode(':', $_SESSION['msg'], 2);
                $alertType = $type === 'success' ? 'success' : 'danger';
                ?>
                <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo ucfirst($type); ?>!</strong> <?php echo htmlentities($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php
                $_SESSION['msg'] = "";
            }
            ?>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-semibold">
                    Update Your Password
                </div>
                <div class="card-body">
                    <form name="chngpwd" method="post" onsubmit="return validatePassword()">
                        <div class="mb-3">
                            <label for="password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="newpassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="newpassword" id="newpassword" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include('include/footer.php'); ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validatePassword() {
    const form = document.forms['chngpwd'];
    const oldPwd = form['password'].value;
    const newPwd = form['newpassword'].value;
    const confirmPwd = form['confirmpassword'].value;

    if (!oldPwd || !newPwd || !confirmPwd) {
        alert("All fields are required!");
        return false;
    }
    if (newPwd !== confirmPwd) {
        alert("New password and confirm password do not match!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
<?php } ?>
