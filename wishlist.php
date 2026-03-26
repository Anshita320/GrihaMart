<?php
include("config.php");
session_start();

// LOGIN CHECK
if(!isset($_SESSION['user_id'])){
    echo "login_required";
    exit();
}

$user_id = intval($_SESSION['user_id']);
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($product_id <= 0){
    echo "invalid";
    exit();
}

// CHECK EXIST
$check = mysqli_query($conn, 
"SELECT id FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'");

if(mysqli_num_rows($check) > 0){

    // REMOVE
    mysqli_query($conn, 
    "DELETE FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'");
    
    echo "removed";

}else{

    // ADD
    mysqli_query($conn, 
    "INSERT INTO wishlist(user_id, product_id) VALUES('$user_id','$product_id')");
    
    echo "added";
}
?>