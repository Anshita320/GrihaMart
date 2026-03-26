<?php
session_start();
include("config.php");
include("includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: customer/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$products = mysqli_query($conn,"
SELECT p.* FROM wishlist w
JOIN products p ON w.product_id = p.id
WHERE w.user_id='$user_id'
");
?>

<style>
.product-card{
background:white;
border-radius:12px;
padding:15px;
text-align:center;
transition:0.3s;
font-weight: bold;
}
.product-card:hover{
transform:translateY(-5px);
box-shadow:0 8px 20px rgba(0,0,0,0.1);
}
.product-card img{
width:100%;
height:350px;
object-fit:contain;
max-width: 600px;
}
.buttons{
display:flex;
gap:6px;
}
.buttons .btn{
flex:1;
font-size:12px;
}

@media (max-width:768px){

/* sidebar full width */
.col-md-3{
    width:100%;
}

/* product area full width */
.col-md-9{
    width:100%;
}

/* 2 cards per row already (col-6 ✔) */

/* card compact */
.product-card{
    padding:8px;
}

/* image smaller */
.product-card img{
    height:140px;
}

/* text smaller */
.product-card h6{
    font-size:12px;
}

.product-card p{
    font-size:12px;
}

/* buttons stacked clean */
.buttons{
    flex-direction:column;
}

.buttons .btn{
    font-size:11px;
    padding:5px;
}

}
</style>

<div class="container mt-4">

<div class="row">

<?php include("includes/account_sidebar.php"); ?>

<div class="col-md-9">

<h4 class="mb-4">❤️ My Wishlist</h4>

<div class="row g-3">

<?php while($row=mysqli_fetch_assoc($products)){ ?>

<div class="col-md-4 col-6">

<div class="product-card">

<img src="images/<?php echo $row['image']; ?>">

<h6><?php echo $row['name']; ?></h6>
<p>₹<?php echo $row['price']; ?></p>

<div class="buttons">

<a href="product.php?id=<?php echo $row['id']; ?>" 
class="btn btn-outline-dark btn-sm">
View Details
</a>

<button class="btn btn-warning add-to-cart" 
data-id="<?php echo $row['id']; ?>">
Add to Cart
</button>

<button class="btn btn-danger remove-wishlist" 
data-id="<?php echo $row['id']; ?>">
Remove
</button>

</div>

</div>
</div>

<?php } ?>

<?php if(mysqli_num_rows($products)==0){
echo "<p>No items in wishlist</p>";
} ?>

</div>

</div>
</div>

</div>

<script>

// ADD TO CART
document.querySelectorAll(".add-to-cart").forEach(btn=>{
btn.addEventListener("click", function(){

let id = this.dataset.id;

fetch("add_to_cart.php", {
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"product_id="+id
})
.then(res=>res.text())
.then(()=>{
alert("Added to cart ✅");
});

});
});

// REMOVE WISHLIST
document.querySelectorAll(".remove-wishlist").forEach(btn=>{
btn.addEventListener("click", function(){

let id = this.dataset.id;

fetch("wishlist.php?id="+id)
.then(res=>res.text())
.then(()=>{
location.reload();
});

});
});

</script>

<?php include("includes/footer.php"); ?>