<?php
session_start();
include("config.php");
include("includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: customer/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ================= ADD ADDRESS ================= */
if(isset($_POST['add_address'])){

    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];

    // If first address, make default automatically
    $check = mysqli_query($conn,"SELECT * FROM customer_addresses WHERE user_id='$user_id'");
    $is_default = (mysqli_num_rows($check) == 0) ? 1 : 0;

    mysqli_query($conn,"INSERT INTO customer_addresses 
    (user_id, full_name, phone, pincode, state, city, address_line1, address_line2, is_default)
    VALUES
    ('$user_id','$full_name','$phone','$pincode','$state','$city','$address1','$address2','$is_default')");
}

/* ================= SET DEFAULT ================= */
if(isset($_GET['set_default'])){
    $id = $_GET['set_default'];

    mysqli_query($conn,"UPDATE customer_addresses SET is_default=0 WHERE user_id='$user_id'");
    mysqli_query($conn,"UPDATE customer_addresses SET is_default=1 WHERE id='$id' AND user_id='$user_id'");
}

/* ================= DELETE ADDRESS ================= */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM customer_addresses WHERE id='$id' AND user_id='$user_id'");
}

$addresses = mysqli_query($conn,"SELECT * FROM customer_addresses WHERE user_id='$user_id'");
?>

<style>
body{background:#f5f7fa;}
.address-card{
    border-radius:15px;
    transition:0.3s;
}
.address-card:hover{
    transform:translateY(-5px);
}
.default-badge{
    font-size:12px;
}

.sidebar{
background:white;
padding:20px;
border-radius:6px;
}

.sidebar a{
display:block;
padding:10px;
text-decoration:none;
color:black;
}

.sidebar a:hover{
background:#f5f5f5;
}
</style>

<div class="container py-5">
<div class="row">
 <?php include "includes/account_sidebar.php"; ?>
<div class="col-md-9">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>My Addresses</h3>
</div>

<!-- Add Address Form -->
<div class="card shadow mb-4">
<div class="card-body">
<h5 class="mb-3">Add New Address</h5>

<form method="POST">
<div class="row g-3">

<div class="col-md-6">
<input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
</div>

<div class="col-md-6">
<input type="text" name="phone" class="form-control" placeholder="Mobile Number" required>
</div>

<div class="col-md-4">
<input type="text" name="pincode" class="form-control" placeholder="Pincode" required>
</div>

<div class="col-md-4">
<input type="text" name="state" class="form-control" placeholder="State" required>
</div>

<div class="col-md-4">
<input type="text" name="city" class="form-control" placeholder="City" required>
</div>

<div class="col-12">
<textarea name="address1" class="form-control" placeholder="House No, Street Area" required></textarea>
</div>

<div class="col-12">
<textarea name="address2" class="form-control" placeholder="Landmark (Optional)"></textarea>
</div>

</div>

<button type="submit" name="add_address" class="btn btn-dark mt-3">
Save Address
</button>

</form>
</div>
</div>

<!-- Saved Addresses -->
<div class="row">
<?php while($row = mysqli_fetch_assoc($addresses)) { ?>
<div class="col-md-6 mb-4">

<div class="card shadow-sm address-card p-3">

<div class="d-flex justify-content-between">
    <h6 class="fw-bold mb-1"><?php echo $row['full_name']; ?></h6>

    <?php if($row['is_default']==1){ ?>
        <span class="badge bg-success default-badge">Default</span>
    <?php } ?>
</div>

<p class="mb-1">
<?php echo $row['address_line1']; ?>,<br>
<?php echo $row['address_line2']; ?><br>
<?php echo $row['city']; ?>,
<?php echo $row['state']; ?> -
<?php echo $row['pincode']; ?><br>
Phone: <?php echo $row['phone']; ?>
</p>

<div class="mt-2">

<?php if($row['is_default']==0){ ?>
<a href="?set_default=<?php echo $row['id']; ?>" 
class="btn btn-outline-primary btn-sm">
Set as Default
</a>
<?php } ?>

<a href="?delete=<?php echo $row['id']; ?>" 
class="btn btn-outline-danger btn-sm"
onclick="return confirm('Delete this address?')">
Delete
</a>

</div>

</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>

<?php include("includes/footer.php"); ?>