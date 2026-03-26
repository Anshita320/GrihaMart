<?php
$conn = mysqli_connect("localhost", "root", "", "grihamart");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
?>