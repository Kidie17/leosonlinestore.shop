<?php
session_start();
include_once 'includes/config.php';

// Check login
$isLoggedIn = isset($_SESSION['login']) && strlen($_SESSION['login']) > 0;
$username   = $isLoggedIn ? $_SESSION['username'] : "";

// Cart Count
$cart_count = 0;
$cartItems  = [];

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $cartQuery = mysqli_query($con, "SELECT COUNT(id) AS total FROM cart WHERE user_id=$user_id");
    $cart_count = mysqli_fetch_assoc($cartQuery)['total'];

    $cartItems = mysqli_query($con, "SELECT * FROM cart WHERE user_id=$user_id");
}
?>

<!-- ✅ NAV BAR (your desired format) -->
<div class="header-nav animate-dropdown">
    <div class="container">

        <nav class="navbar navbar-default">

            <!-- ✅ BRAND + MOBILE TOGGLE -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php"></a>
            </div>

            <div class="collapse navbar-collapse" id="main-menu">

                <!-- ✅ LEFT: CATEGORIES -->
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>

                    <?php
                    $categoryQuery = mysqli_query($con, "SELECT id, categoryName FROM category LIMIT 6");
                    while ($row = mysqli_fetch_assoc($categoryQuery)) {
                    ?>
                        <li><a href="category.php?cid=<?= $row['id']; ?>">
                            <?= $row['categoryName']; ?>
                        </a></li>
                    <?php } ?>
                </ul>

                <!-- ✅ MIDDLE: SEARCH BAR -->
                <form class="navbar-form navbar-left" action="search-result.php" method="post">
                    <div class="form-group">
                        <input type="text" name="product" class="form-control" placeholder="Search here..." required>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <!-- ✅ RIGHT SIDE: CART + USER -->
                <ul class="nav navbar-nav navbar-right">

                    <!-- ✅ CART DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                            <span class="badge"><?= $cart_count ?></span>
                        </a>

                        <ul class="dropdown-menu" style="width:300px; padding:15px;">

                        <?php if ($cart_count > 0) { ?>

                            <?php
                            $total = 0;
                            while ($item = mysqli_fetch_assoc($cartItems)) {
                                $productId = $item['item_id'];
                                $product = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM products WHERE id=$productId"));

                                $subtotal = $product['productPrice'] + $product['shippingCharge'];
                                $total += $subtotal;
                            ?>
                            <li style="padding-bottom:10px; border-bottom:1px solid #eee;">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="admin/productimages/<?= $product['id']; ?>/<?= $product['productImage1']; ?>" width="60">
                                    </div>
                                    <div class="media-body">
                                        <h5>
                                            <a href="product-details.php?pid=<?= $product['id']; ?>">
                                                <?= $product['productName']; ?>
                                            </a>
                                        </h5>
                                        <small>₱ <?= number_format($subtotal, 2); ?></small>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>

                            <li style="padding-top:10px; border-top:1px solid #eee; font-weight:bold;">
                                <span>Total:</span>
                                <span class="pull-right">₱ <?= number_format($total, 2); ?></span>
                            </li>

                            <li style="padding-top:10px;">
                                <a href="my-cart.php" class="btn btn-primary btn-block">View Cart</a>
                            </li>

                        <?php } else { ?>

                            <li class="text-center" style="padding:20px;">
                                <i class="glyphicon glyphicon-shopping-cart" style="font-size:30px; color:#aaa;"></i>
                                <p>Your cart is empty.</p>
                                <a href="index.php" class="btn btn-primary btn-block">Continue Shopping</a>
                            </li>

                        <?php } ?>

                        </ul>
                    </li>

                    <!-- ✅ USER BUTTON -->
                    <?php if ($isLoggedIn) { ?>
                    <li class="dropdown" style="position:relative; margin-top:15px;">
                        <a href="#" class="dropdown-toggle user-btn" data-toggle="dropdown"
                        style="
                                padding:6px 12px; background:#fff; border-radius:25px;
                                border:1px solid #007bff; color:#007bff; font-weight:600;
                                display:flex; align-items:center; gap:6px;
                        ">
                        <i class="fa fa-user-circle"></i>
                        Welcome, <?= htmlentities($username); ?>
                        <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu user-dropdown"
                            style="
                                min-width:180px;
                                background:#fff;
                                border:1px solid #ddd;
                                border-radius:6px;
                                box-shadow:0 2px 6px rgba(0,0,0,0.15);
                                padding:8px 0;
                            ">
                            <li><a href="my-account.php" style="font-size: 20px; padding: 10px;">
                                <i class="fa fa-user"></i> My Account</a></li>

                            <li><a href="logout.php" style="font-size: 20px; padding: 10px;">
                                <i class="fa fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                    <?php } else { ?>
                        <li><a href="login.php" class="btn btn-primary" style="border-radius:25px;">
                            <i class="fa fa-sign-in-alt"></i> Login
                        </a></li>
                    <?php } ?>

                </ul>

            </div>

        </nav>

    </div>
</div>
