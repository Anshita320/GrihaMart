<?php
include '../config.php';

if (isset($_POST['add_product'])) {

    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);


    $image_name = $_FILES['image']['name'];
    $temp_name  = $_FILES['image']['tmp_name'];
    $folder     = "../images/" . $image_name;

    move_uploaded_file($temp_name, $folder);

    $sql = "INSERT INTO products (name, price, category, subcategory_id, description, image)
            VALUES ('$name', '$price', '$category', '$subcategory', '$description', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Added Successfully!'); window.location='add_product.php';</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background: linear-gradient(135deg,#eef2ff,#f8fafc);
font-family:'Segoe UI', sans-serif;
}

.form-box{
max-width:600px;
margin:auto;
background:#fff;
padding:25px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="form-box mt-5">


<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>➕ Add New Product</h2>
    <a href="dashboard.php" class="btn btn-secondary">⬅ Back</a>
</div>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" class="form-control mb-3" placeholder="Product Name" required>

<input type="number" name="price" class="form-control mb-3" placeholder="Price" required>

<!-- CATEGORY -->
<select name="category" class="form-control mb-3" required>
<option value="">Select Category</option>
<option value="Jewelry">Jewelry</option>
<option value="Candles">Candles</option>
<option value="Crochet">Crochet</option>
<option value="Wooden">Wooden</option>
<option value="Art">Art</option>
<option value="Decor">Decor</option>
<option value="Beauty">Beauty</option>
<option value="Paper">Paper</option>
<option value="Fabric">Fabric</option>
<option value="Toys">Toys</option>
<option value="Gifts">Gifts</option>
<option value="Food">Food</option>
<option value="Spiritual">Spiritual</option>
<option value="Stationery">Stationery</option>
</select>

<!-- ✅ SUBCATEGORY (DB BASED) -->
<select name="subcategory" class="form-control mb-3" required>

<option value="">Select Subcategory</option>

<?php
$subs = mysqli_query($conn, "SELECT * FROM subcategories");
while($s = mysqli_fetch_assoc($subs)){
?>
<option value="<?php echo $s['id']; ?>">
<?php echo $s['name']; ?>
</option>
<?php } ?>

</select>

<textarea name="description" class="form-control mb-3" placeholder="Description" required></textarea>

<input type="file" name="image" class="form-control mb-3" required>

<button type="submit" name="add_product" class="btn btn-dark w-100">
Add Product
</button>

</form>

</div>

</body>
</html>