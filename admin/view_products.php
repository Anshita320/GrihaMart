<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// DELETE PRODUCT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
    
    header("Location: view_products.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="mb-4">All Products</h2>

<table class="table table-bordered table-hover shadow">
<tr class="table-dark">
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td>₹<?php echo $row['price']; ?></td>
    <td>
        <img src="../images/<?php echo $row['image']; ?>" width="60">
    </td>
    <td>
        <!-- EDIT BUTTON -->
        <a href="edit_product.php?id=<?php echo $row['id']; ?>" 
           class="btn btn-primary btn-sm">
           Edit
        </a>

        <!-- DELETE BUTTON -->
        <a href="view_products.php?delete=<?php echo $row['id']; ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure you want to delete this product?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

<br>
<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>

</body>
</html>