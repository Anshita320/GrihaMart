<?php
include("../config.php");

if(isset($_POST['upload']))
{
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"../images/".$image);

mysqli_query($conn,"INSERT INTO banners(image) VALUES('$image')");
}

?>

<form method="POST" enctype="multipart/form-data">

<h3>Upload Banner</h3>

<input type="file" name="image" required>

<button name="upload">Upload</button>

</form>