<?php
session_start();
include("config.php");
include("includes/header.php");

$total = 0;
?>

<style>

/* Mobile Responsive */
@media(max-width:768px){

table{
font-size:14px;
}

th, td{
padding:6px !important;
}

.btn{
font-size:14px;
padding:6px;
}

}

/* Remove button */
.remove-btn{
background:red;
color:white;
border:none;
padding:5px 10px;
border-radius:6px;
cursor:pointer;
}

</style>

<div class="container mt-4">
<h2 class="text-center">🛒 Your Cart</h2>

<?php if(!empty($_SESSION['cart'])) { ?>

<div class="table-responsive">

<table class="table table-bordered text-center align-middle">

<tr>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
<th>Action</th>
</tr>

<?php 
foreach($_SESSION['cart'] as $id => $qty) {

$id = (int)$id;
$qty = (int)$qty;

$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if($product){

$price = (int)$product['price'];
$subTotal = $price * $qty;
$total += $subTotal;
?>

<tr>

<td><?php echo $product['name']; ?></td>

<td>₹<?php echo $price; ?></td>

<td><?php echo $qty; ?></td>

<td>₹<?php echo $subTotal; ?></td>

<td>
<a href="remove_from_cart.php?id=<?php echo $id; ?>" 
class="remove-btn">Remove</a>
</td>

</tr>

<?php } } ?>

<tr>
<th colspan="3">Grand Total</th>
<th colspan="2">₹<?php echo $total; ?></th>
</tr>

</table>
</div>

<!-- BUTTONS -->
<div class="mt-3">

<a href="checkout.php?buy=now" class="btn btn-success w-100">
Buy All Now
</a>

</div>
<?php } else { ?>

<h4 class="text-danger text-center mt-4">Cart is Empty</h4>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>