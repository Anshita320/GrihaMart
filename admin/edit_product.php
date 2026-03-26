<?php
include '../config.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($result);

if (isset($_POST['update_product'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {

        $image_name = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $folder = "../images/" . $image_name;

        move_uploaded_file($temp_name, $folder);

        $update = "UPDATE products 
                   SET name='$name', price='$price', image='$image_name'
                   WHERE id='$id'";
    } else {

        $update = "UPDATE products 
                   SET name='$name', price='$price'
                   WHERE id='$id'";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Product Updated Successfully!'); window.location='view_products.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" 
           value="<?php echo $product['name']; ?>" 
           class="form-control mb-3" required>

    <input type="number" name="price" 
           value="<?php echo $product['price']; ?>" 
           class="form-control mb-3" required>

    <p>Current Image:</p>
    <img src="../images/<?php echo $product['image']; ?>" 
         width="120" class="mb-3">

    <input type="file" name="image" class="form-control mb-3">

    <button type="submit" name="update_product" 
            class="btn btn-dark w-100">
        Update Product
    </button>

</form>

</body>
</html>