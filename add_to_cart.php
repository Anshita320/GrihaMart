<?php
session_start();
include("config.php");

if (isset($_POST['product_id'])) {

    $product_id = (int)$_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // 🔥 FIX: prevent double increment
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        // 🔥 only increase if request is intentional
        if(!isset($_POST['from_cart'])){
            $_SESSION['cart'][$product_id] = 1; // reset instead of double
        }
    }

    echo "added";

} else {
    echo "no product_id";
}
?>