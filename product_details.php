<?php
include("config.php");

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM products WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
?>