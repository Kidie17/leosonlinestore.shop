<?php 
session_start();
include('includes/config.php');
$user_id = $_SESSION['id'];
if(isset($_POST['add_to_cart'])){
	$id=intval($_GET['id']);

	$validateItem = mysqli_query($con, "SELECT * FROM cart WHERE item_id = $id");
	if(mysqli_num_rows($validateItem) > 0){
		echo "<script>alert('Product is existing'); location.href='index.php'</script>";
        exit;
	}
	
	$insert = mysqli_query($con, "INSERT INTO cart VALUES('0', '$id', '$user_id')");

	if($insert){
		echo "<script>alert('Product added to cart'); location.href='index.php'</script>";
	}

}


if(isset($_POST['remove_to_cart'])){

    $item_id = intval($_POST['item_id']); // cart row ID

    echo $item_id;

    $delete = mysqli_query($con, 
        "DELETE FROM cart WHERE id = $item_id AND user_id = $user_id"
    );

    if($delete){
        header("Location: my-cart.php");
        exit;
    }

}

if(isset($_POST['checkout'])){

    // ✅ Get selected cart rows
    $selectedItems = $_POST['selected_items']; // array of cart_id

    // ✅ Get all quantities
    $allQty = $_POST['qty']; 


    $selectedQty = [];
    foreach ($selectedItems as $cart_id) {
        if (isset($allQty[$cart_id])) {
            $selectedQty[$cart_id] = $allQty[$cart_id];
        }
    }

    $_SESSION['staging_items'] = $selectedItems;
    $_SESSION['staging_qty']   = $selectedQty;

    header("Location: payment-method.php");
    exit;
}

if(isset($_POST['submit'])){
    $selectedItems = $_SESSION['staging_items'];  // array of cart_id
    $qtyList       = $_SESSION['staging_qty'];    // cart_id => qty

    $total = 0;

    foreach($selectedItems as $cart_id){

        // 1️⃣ Get cart row → gives product ID
        $cartRes = mysqli_query($con, "SELECT item_id FROM cart WHERE id = $cart_id");
        $cartRow = mysqli_fetch_assoc($cartRes);
        $product_id = $cartRow['item_id'];

        // 2️⃣ Get product price
        $prodRes = mysqli_query($con, "SELECT productPrice FROM products WHERE id = $product_id");
        $prodRow = mysqli_fetch_assoc($prodRes);
        $price = $prodRow['productPrice'];

        // 3️⃣ Get selected quantity
        $qty = $qtyList[$cart_id];

        // 4️⃣ Multiply
        $subtotal = $price * $qty;
        $total += $subtotal;
    }

    $total += 55.00;



    if($_POST['payment_method'] !== 'COD'){
       $secret_key = "sk_test_kkuKh6jArg5oGWaVh9xV8Tmx";

        // -----------------------------
        // Build checkout session payload
        // -----------------------------
        $checkout_data = [
            "data" => [
                "attributes" => [
                    'send_email_receipt' => true,
                    "line_items" => [
                        [
                            "name" => "Leo's Parts Shop and Accessories",
                            "description" => "This is a test item",
                            "amount" => $total * 100,
                            "currency" => "PHP",
                            "quantity" => 1
                        ]
                    ],
                    "payment_method_types" => ["gcash"],
                    "success_url" => "http://localhost/kid/process_payment.php",
                    "cancel_url"  => "http://localhost/kid/my-cart.php"
                ]
            ]
        ];

        // -----------------------------
        // Create the Checkout Session
        // -----------------------------
        $ch = curl_init("https://api.paymongo.com/v1/checkout_sessions");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($checkout_data));

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // -----------------------------
        // Handle PayMongo Response
        // -----------------------------
        if ($http_status == 200 || $http_status == 201) {
            $result = json_decode($response, true);
            
            // Get the PayMongo hosted checkout url
            $checkout_url = $result["data"]["attributes"]["checkout_url"];

            // Redirect user to PayMongo checkout
            header("Location: " . $checkout_url);
            exit;
        }

        echo "<pre>Error creating checkout:\n";
        print_r($response);
        echo "</pre>";
    } else {
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
        ($user_id, $product_id, $qty, 'COD', NOW(), 'pending')
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
    }
}




?>