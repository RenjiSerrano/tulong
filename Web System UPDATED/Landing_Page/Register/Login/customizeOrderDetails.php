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
      <a href="customization.php">Customize</a>
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
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tracking_number = '';
    $length = 10; 

    for ($i = 0; $i < $length; $i++) {
        $tracking_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $tracking_number;
}

if (isset($_POST['order_btn'])) {
    // Fetch the latest row from cart_customize table
    $latest_cart_query = mysqli_query($conn, "SELECT * FROM `cart_customize` ORDER BY customize_id DESC LIMIT 1");

    // Check if the query returned any row
    if (mysqli_num_rows($latest_cart_query) > 0) {
        $product_item = mysqli_fetch_assoc($latest_cart_query);

        // Access the latest row's data
        $product_name = $product_item['brand'] . ' (' . $product_item['colorway'] . ') (' . $product_item['customization'] . ') (' . $product_item['quantity'] . ')';
        $price_total = $product_item['price'] * $product_item['quantity'];

        // Extract additional details
        $brand = $product_item['brand'];
        $colorway = $product_item['colorway'];
        $customization = $product_item['customization'];
        $sizes = $product_item['sizes'];

        // Retrieve other form data
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $method = $_POST['method'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $barangay = $_POST['barangay'];
        $street = $_POST['street'];

        // Generate a unique tracking number
        $tracking_number = generateTrackingNumber();

        // Insert order details into the database including brand, colorway, customization, sizes
        $detail_query = mysqli_query($conn, "INSERT INTO `customize_orders` (tracking_number, name, phone_number, method, province, city, barangay, street, total_products, total_price, brand, colorway, customization, sizes) 
                        VALUES ('$tracking_number', '$name', '$phone_number', '$method', '$province', '$city', '$barangay', '$street', '$product_name', '$price_total', '$brand', '$colorway', '$customization', '$sizes')") or die('query failed');

        if ($detail_query) {
            echo "
            <div class='order-message-container'>
                <div class='message-container'>
                    <h3>Thank you for shopping!</h3>
                    <!-- Other order details here -->
                    <p>Your tracking number: <strong>$tracking_number</strong></p>
                    <p>Order details:</p>
                    <div class='order-detail'>
                        <span>$product_name</span>
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
}
?>

</body>
</html>