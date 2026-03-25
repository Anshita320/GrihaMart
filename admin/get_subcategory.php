<?php
include '../config.php';

$cat_id = $_GET['cat_id'];

$query = mysqli_query($conn,
"SELECT * FROM subcategories WHERE category_id='$cat_id'");

echo "<option value=''>Select Subcategory</option>";

while($row=mysqli_fetch_assoc($query)){
echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>