<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/orderDetails.css">
   <title>checkout</title>

   <header class="header">

<div class="flex">

   <a href="#" class="logo">Once</a>

   <nav class="navbar">
      <a href="user_page.php">Home</a>
      <a href="products.php">Products</a>
      <a href="cart.php">Cart</a>
      <a href="logout.php" class="logout">logout</a>
   </nav>


</div>

</header>

 

</head>
<body>

<?php
// Include database connection file
include_once 'once_db.php';

// Function to generate a random tracking number
function generateTrackingNumber() {
    // You can customize this function to generate your tracking number (e.g., random alphanumeric)
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tracking_number = '';
    $length = 10; // Change the length of your tracking number if needed

    for ($i = 0; $i < $length; $i++) {
        $tracking_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $tracking_number;
}

if (isset($_POST['order_btn'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $method = $_POST['method'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];

    // Fetch cart items
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;
    $product_name = [];

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ')';
            $price_total += $product_item['price'] * $product_item['quantity'];
        }
    }

    $total_product = implode(', ', $product_name);

    // Generate a unique tracking number
    $tracking_number = generateTrackingNumber();

    // Insert order details into the database
    $detail_query = mysqli_query($conn, "INSERT INTO `orders` (tracking_number, name, phone_number, method, province, city, barangay, street, total_products, total_price) 
                    VALUES ('$tracking_number', '$name', '$phone_number', '$method', '$province', '$city', '$barangay', '$street', '$total_product', '$price_total')") or die('query failed');

    if ($detail_query) {
        echo "
        <div class='order-message-container'>
            <div class='message-container'>
                <h3>Thank you for shopping!</h3>
                <!-- Other order details here -->
                <p>Your tracking number: <strong>$tracking_number</strong></p>
                <p>Order details:</p>
                <div class='order-detail'>
                    <span>$total_product</span>
                    <span class='total'>Total: ₱$price_total</span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>$name</span></p>
                    <p>Your number: <span>$phone_number</span></p>
                    <p>Your address: <span>$province, $city, $barangay, $street</span></p>
                    <p>Your payment mode: <span>$method</span></p>
                   
                </div>
                <a href='products.php' class='btn'>Continue shopping</a>
            </div>
        </div>
        ";
    }
    
}
?>



