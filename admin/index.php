<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=password_hash($_POST['password'], PASSWORD_DEFAULT);
	$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username'");
	$num=mysqli_fetch_array($ret);
	if($num>0)
	{
		$extra="todays-orders.php";
		$_SESSION['alogin']=$_POST['username'];
		$_SESSION['id']=$num['id'];
		$host=$_SERVER['HTTP_HOST'];
		$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
		header("location:http://$host$uri/$extra");
		exit();
	}
	else
	{
		$_SESSION['errmsg']="Invalid username or password";
		$extra="index.php";
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
		header("location:http://$host$uri/$extra");
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Des Marketing | Admin login</title>

	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<link href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<style>
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
			background-color: #f0f2f5;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			font-family: 'Poppins', sans-serif;
		}

		.module-login {
			width: 100%;
			max-width: 600px;
			background: #ffffff;
			padding: 40px;
			border: 4px solid #007bff;
			border-radius: 12px;
			box-shadow: 0 8px 16px rgba(0,0,0,0.1);
			text-align: center;
		}

		.module-head h3 {
			font-size: 28px;
			margin-bottom: 30px;
			color: #007bff;
			font-weight: 600;
		}

		.module-body input {
			height: 45px;
			font-size: 20px;
			font-family: 'Poppins', sans-serif;
		}

		.module-foot .btn {
			padding: 20px 24px;
			font-size: 16px;
			font-weight: 500;
			font-family: 'Poppins', sans-serif;
		}

		.navbar, .footer {
			display: none;
		}
	</style>
</head>
<body>

	<div class="module module-login">
		<form class="form-vertical" method="post">
			<div class="module-head">
				<h3>ADMIN SIGN IN</h3>
			</div>
			<span style="color:red;">
				<?php echo htmlentities($_SESSION['errmsg']); ?>
				<?php echo htmlentities($_SESSION['errmsg']="");?>
			</span>
			<div class="module-body">
				<div class="control-group">
					<div class="controls row-fluid">
						<input class="span12" type="text" name="username" placeholder="Username">
					</div>
				</div>
				<div class="control-group">
					<div class="controls row-fluid">
						<input class="span12" type="password" name="password" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="module-foot">
				<div class="control-group">
					<div class="controls clearfix">
						<button type="submit" class="btn btn-primary pull-center" name="submit">Login</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<script src="scripts/jquery-1.9.1.min.js"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
