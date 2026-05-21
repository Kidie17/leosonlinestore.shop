<?php 
session_start();
include_once 'includes/config.php';
$user_id = $_SESSION['id'];

$selectedItems = $_SESSION['staging_items'];    // [cart_id, cart_id, ...]
$qtyList       = $_SESSION['staging_qty'];      // cart_id => qty

foreach ($selectedItems as $cart_id) {

    // 1️⃣ Get product ID from cart
    $cartRes = mysqli_query($con, "
        SELECT item_id 
        FROM cart 
        WHERE id = $cart_id
    ");
    $cartRow = mysqli_fetch_assoc($cartRes);

    $product_id = $cartRow['item_id'];

    // 2️⃣ Get product price & shipping
    $prodRes = mysqli_query($con, "
        SELECT productPrice, shippingCharge, productName 
        FROM products 
        WHERE id = $product_id
    ");
    $prod = mysqli_fetch_assoc($prodRes);

    $price     = $prod['productPrice'];
    $shipping  = $prod['shippingCharge'];
    $qty       = $qtyList[$cart_id];

    // 3️⃣ Calculate subtotal
    $subtotal = ($price * $qty) + $shipping;

    // 4️⃣ Insert into order_items
    mysqli_query($con, "
        INSERT INTO orders
        (userId, productId, quantity, paymentMethod, orderDate, orderStatus)
        VALUES
        ($user_id, $product_id, $qty, 'e-wallet', NOW(), 'pending')
    ");

     mysqli_query($con, "
        DELETE FROM cart 
        WHERE id = $cart_id 
        AND item_id = $product_id
        AND user_id = $user_id
    ");
}

    unset($_SESSION['staging_items']);
    unset($_SESSION['staging_qty']);

    header("location: index.php");
?>