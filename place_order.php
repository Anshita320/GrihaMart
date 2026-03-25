<?php
session_start();
include("config.php");

if (!isset($_SESSION['user'])) {
    header("Location: customer/login.php");
    exit();
}

if (!empty($_SESSION['cart'])) {

    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $user = $_SESSION['user'];

    // 1️⃣ Insert into orders table
    $query = "INSERT INTO orders (user_name, total_amount, status) 
              VALUES ('$user', '$total', 'Pending')";

    if (mysqli_query($conn, $query)) {

        // Get last inserted order ID
        $order_id = mysqli_insert_id($conn);

        // 2️⃣ Insert each cart item into order_items
       foreach ($_SESSION['cart'] as $product_id => $item) {

    $quantity = $item['qty'];
    $price    = $item['price'];

    $insert_item = "INSERT INTO order_items 
                    (order_id, product_id, quantity, price)
                    VALUES 
                    ('$order_id', '$product_id', '$quantity', '$price')";

    mysqli_query($conn, $insert_item);
}

        // Clear cart
        unset($_SESSION['cart']);

        echo "<script>
                alert('Order Placed Successfully!');
                window.location='my_orders.php';
              </script>";
        exit();

    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
?>