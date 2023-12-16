<?php

@include 'once_db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Once Admin Page</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/adminCSS.css">
</head>
<body>

<header class="header">
   <div class="flex">
      <a href="#" class="logo">Once</a>

      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="add_products.php">Add products</a>
         <a href="viewCustomer.php">Customer</a>
         <a href="#">Sales</a>
         <a href="logout.php" class="logout">logout</a>
      </nav>

   </div>
</header>

<div id="ordersBtn">
    <h2>Order Details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Status</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <?php
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        $totalPaidSales = 0; // Initializing total paid sales variable

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["phone_number"] ?></td>
                    <td><?= $row["order_date"] ?></td>
                    <td>₱<?= $row["total_price"] ?></td>
                    <td><?= $row["method"] ?></td>
                    <td>
                        <?php if ($row["order_status"] == 0): ?>
                            <button class="btn btn-danger change-order-status"
                                    onclick="ChangeOrderStatus('<?= $row['id'] ?>', 1)">Pending</button>
                        <?php else: ?>
                            <button class="btn btn-success change-order-status"
                                    onclick="ChangeOrderStatus('<?= $row['id'] ?>', 0)">Delivered</button>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row["payment_status"] == 0): ?>
                            <button class="btn btn-danger change-payment-status"
                                    onclick="ChangePaymentStatus('<?= $row['id'] ?>', 1)">Unpaid</button>
                        <?php else: ?>
                            <button class="btn btn-success change-payment-status"
                                    onclick="ChangePaymentStatus('<?= $row['id'] ?>', 0)">Paid</button>
                            <?php
                            // Calculate total sales for 'Paid' status
                            $totalPaidSales += $row["total_price"]; // Add total price to the total paid sales
                            ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>

    <p class="total-sales">Total Sales: ₱<?= $totalPaidSales ?></p> 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function ChangeOrderStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updateOrderStatus.php',
            data: {
                order_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                // Here you can handle the response, if needed
                location.reload(); // Reload the page to reflect the updated status
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle errors here
            }
        });
        
    }

    function ChangePaymentStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'updatePayStatus.php',
            data: {
                order_id: orderId,
                new_status: newStatus
            },
            success: function(response) {
                // Here you can handle the response, if needed
                location.reload(); // Reload the page to reflect the updated status
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle errors here
            }
        });
        
    }
</script>

</body>
</html>