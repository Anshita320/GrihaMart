<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* UPDATE STATUS */
if (isset($_POST['update_status'])) {

    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status   = mysqli_real_escape_string($conn, $_POST['status']);

    $check = mysqli_query($conn, 
        "SELECT status FROM orders WHERE id='$order_id'"
    );

    $data = mysqli_fetch_assoc($check);

    if ($data && $data['status'] != "Delivered" && $data['status'] != "Cancelled") {

        mysqli_query($conn, 
            "UPDATE orders SET status='$status' WHERE id='$order_id'"
        );
    }

    header("Location: view_orders.php?updated=1");
    exit();
}

$result = mysqli_query($conn, 
    "SELECT * FROM orders ORDER BY order_date DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>View Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="mb-4">All Orders</h2>

<?php if (isset($_GET['updated'])) { ?>
<div class="alert alert-success">
    Order status updated successfully!
</div>
<?php } ?>

<table class="table table-bordered table-hover align-middle text-center">
<tr class="table-dark">
    <th>ID</th>
    <th>User</th>
    <th>Total</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['user_name']; ?></td>
    <td>₹<?php echo $row['total_amount']; ?></td>
    <td><?php echo $row['order_date']; ?></td>

    <td>
        <?php
        $status = $row['status'];

        if ($status == "Pending") {
            echo "<span class='badge bg-warning text-dark'>Pending</span>";
        }
        elseif ($status == "Shipped") {
            echo "<span class='badge bg-primary'>Shipped</span>";
        }
        elseif ($status == "Delivered") {
            echo "<span class='badge bg-success'>Delivered</span>";
        }
        elseif ($status == "Cancelled") {
            echo "<span class='badge bg-danger'>Cancelled</span>";
        }
        ?>
    </td>

    <td>

        <!-- UPDATE STATUS FORM -->
        <?php if ($status != "Delivered" && $status != "Cancelled") { ?>
        <form method="POST" class="d-flex mb-2">
            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

            <select name="status" class="form-select me-2">
                <option value="Pending" <?php if($status=="Pending") echo "selected"; ?>>Pending</option>
                <option value="Shipped" <?php if($status=="Shipped") echo "selected"; ?>>Shipped</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <button type="submit" name="update_status" class="btn btn-sm btn-primary">
                Update
            </button>
        </form>
        <?php } else { ?>
            <span class="text-muted d-block mb-2">No Status Change</span>
        <?php } ?>

        <!-- DOWNLOAD INVOICE -->
        <a href="../invoice.php?id=<?php echo $row['id']; ?>" 
           class="btn btn-sm btn-outline-dark">
           Download Invoice
        </a>

    </td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>

</body>
</html>