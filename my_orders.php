<?php
session_start();
include("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: customer/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

/* CANCEL ORDER */
if (isset($_GET['cancel'])) {

    $order_id = $_GET['cancel'];

    $check = mysqli_query($conn,
        "SELECT * FROM orders 
         WHERE id='$order_id' 
         AND user_id='$user_id' 
         AND status='Pending'"
    );

    if (mysqli_num_rows($check) > 0) {

        mysqli_query($conn,
            "UPDATE orders SET status='Cancelled' WHERE id='$order_id'"
        );

    }

    header("Location: my_orders.php");
    exit();
}


/* FETCH ORDERS */

$query = "
SELECT o.id AS order_id,
       o.total_amount,
       o.order_date,
       o.status,
       p.name,
       p.image,
       oi.quantity,
       oi.price
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN products p ON oi.product_id = p.id
WHERE o.user_id = '$user_id'
ORDER BY o.order_date DESC
";

$result = mysqli_query($conn, $query);
?>

<?php include("includes/header.php"); ?>

<div class="container mt-4">

<div class="row">

<!-- SIDEBAR -->
<div class="col-md-3">

<div class="card p-3">

<h6>Hello,</h6>
<h5><?php echo $user_name; ?></h5>

<hr>

<a href="my_orders.php" class="menu-link active">My Orders</a>

<h6 class="mt-3">Account Settings</h6>

<a href="profile.php" class="menu-link">Personal Information</a>

<a href="manage_address.php" class="menu-link">Manage Addresses</a>

<hr>

<a href="customer/logout.php" class="menu-link">Logout</a>

</div>

</div>

<!-- ORDERS -->
<div class="col-md-9">

<h3 class="mb-4">My Orders</h3>

<?php 
if (mysqli_num_rows($result) > 0) {

$current_order = 0;

while($row = mysqli_fetch_assoc($result)) {

if ($current_order != $row['order_id']) {

if ($current_order != 0) {
echo "</div></div>";
}

$status = $row['status'];

/* Estimated Delivery Date (3 days after order) */
$delivery_date = date('d M Y', strtotime($row['order_date'].' +3 days'));
?>

<div class="card mb-4 shadow">

<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

<div>
<strong>Order ID:</strong> <?php echo $row['order_id']; ?> |
<strong>Date:</strong> <?php echo $row['order_date']; ?> |
<strong>Total:</strong> ₹<?php echo $row['total_amount']; ?>
</div>

<div>

<?php
if ($status == "Pending") {
echo "<span class='badge bg-warning text-dark'>Pending</span>";
}
elseif ($status == "Shipped") {
echo "<span class='badge bg-primary'>Shipped</span>";
}
elseif ($status == "Out for Delivery") {
echo "<span class='badge bg-info text-dark'>Out for Delivery</span>";
}
elseif ($status == "Delivered") {
echo "<span class='badge bg-success'>Delivered</span>";
}
elseif ($status == "Cancelled") {
echo "<span class='badge bg-danger'>Cancelled</span>";
}
?>

<a href="invoice.php?id=<?php echo $row['order_id']; ?>" 
class="btn btn-sm btn-light ms-2">
Invoice
</a>

</div>

</div>

<div class="card-body">

<!-- CANCEL BUTTON -->
<?php if ($status == "Pending") { ?>
<div class="text-end mb-3">
<a href="my_orders.php?cancel=<?php echo $row['order_id']; ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Cancel this order?');">
Cancel Order
</a>
</div>
<?php } ?>

<!-- DELIVERY DATE -->
<?php if($status != "Cancelled"){ ?>
<p class="text-success fw-bold">
📦 Expected Delivery: <?php echo $delivery_date; ?>
</p>
<?php } ?>

<!-- 🔥 TIMELINE -->
<div class="timeline">

<div class="timeline-step active">Order Placed</div>

<div class="timeline-step <?php if(in_array($status, ['Shipped','Out for Delivery','Delivered'])) echo 'active'; ?>">
Shipped
</div>

<div class="timeline-step <?php if(in_array($status, ['Out for Delivery','Delivered'])) echo 'active'; ?>">
Out for Delivery
</div>

<div class="timeline-step <?php if($status=='Delivered') echo 'active'; ?>">
Delivered
</div>

<?php if($status=='Cancelled'){ ?>
<div class="timeline-step cancel active">Cancelled</div>
<?php } ?>

</div>

<?php
$current_order = $row['order_id'];

}

?>

<!-- PRODUCT -->
<div class="row align-items-center mb-3 border-bottom pb-3 mt-3">




<div class="col-md-2">

<img src="images/<?php echo $row['image']; ?>" 
class="img-fluid rounded"
style="height:100px; object-fit:cover;">

</div>

<div class="col-md-6">

<h5><?php echo $row['name']; ?></h5>

<p>Quantity: <?php echo $row['quantity']; ?></p>

<p>Price: ₹<?php echo $row['price']; ?></p>

</div>

</div>

<?php } ?>

</div>
</div>

<?php } else { ?>

<div class="alert alert-info">No orders found.</div>

<?php } ?>

</div>

</div>

</div>


<style>

/* Sidebar */
.menu-link{
display:block;
padding:10px;
text-decoration:none;
color:black;
border-radius:5px;
}

.menu-link:hover{
background:#ffc107;

}

.menu-link.active{
background:#ffc107;
}

/* TIMELINE FIXED */
.timeline{
position:relative;
padding-left:35px;
margin:15px 0 20px 0;
width:100%;
clear:both;
}
.timeline::before{
content:'';
position:absolute;
left:10px;
top:0;
width:3px;
height:100%;
background:#ccc;
}
.timeline-step{
position:relative;
margin-bottom:12px;
}
.timeline-step::before{
content:'';
position:absolute;
left:-22px;
top:3px;
width:15px;
height:15px;
border-radius:50%;
background:#ccc;
}
.timeline-step.active{
color:#28a745;
font-weight:600;
}
.timeline-step.active::before{
background:#28a745;
}
.timeline-step.cancel{
color:red;
}
.timeline-step.cancel::before{
background:red;
}

/* MOBILE */
@media(max-width:768px){

.col-md-3, .col-md-9{
width:100% !important;
}

.card-header{
flex-direction:column;
align-items:flex-start !important;
font-size:14px;
}

.row.align-items-center{
flex-direction:column;
text-align:center;
}

img{
height:80px !important;
margin-bottom:10px;
}

.timeline{
padding-left:25px;
}

.timeline-step{
font-size:14px;
}

}

</style>

<?php include("includes/footer.php"); ?>