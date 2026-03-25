<?php
session_start();
include("config.php");
include("includes/header.php");

if(!isset($_GET['id'])){
    echo "<h3 class='text-center mt-5'>Product not found</h3>";
    exit();
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($result);

if(!$product){
    echo "<h3 class='text-center mt-5'>Product not found</h3>";
    exit();
}
?>

<style>
body{ background:#f2ffe6; }

.product-box{
background:white;
padding:30px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

/* IMAGE BOX */
/* IMAGE CONTAINER */
/* IMAGE BOX */
.product-img{
position:relative;
overflow:hidden;
border-radius:16px;
}

/* IMAGE FULL COVER */
.product-img img{
width:100%;
height:350px;
object-fit:cover;   /* 🔥 FULL FILL (no background) */
transition:0.4s ease;
}

/* HOVER ZOOM */
.product-img:hover img{
transform:scale(1.1);
}

/* WRAPPER */
.img-wrapper{
width:100%;
height:100%;
overflow:hidden;
border-radius:16px;
position:relative;
background:#f9f9f9;
display:flex;
justify-content:center;
align-items:center;
}

/* IMAGE */
.img-wrapper img{
max-width:100%;
max-height:100%;
transition:0.5s ease;
transform-origin:center center;
}

/* 🔥 CENTER ZOOM EFFECT */
.img-wrapper:hover img{
transform:scale(1.3);
}

/* OVERLAY LIGHT */
.img-wrapper::after{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0);
transition:0.3s;
border-radius:16px;
}

.img-wrapper:hover::after{
background:rgba(0,0,0,0.05);
}
.product-title{
font-size:22px;
font-weight:600;
text-align: center;
}

.price{
font-size:22px;
color:#2a5298;
font-weight:bold;
margin:10px 0;
text-align: center;
}

.buttons{
display:flex;
justify-content:center;
align-items:center;
gap:10px;
margin-top:15px;
}

.btn-warning{ background:#ffc107; }
.btn-success{ background:#28a745; }
</style>

<div class="container mt-5">

<div class="row">

<!-- LEFT IMAGE -->
<div class="col-md-5">
<div class="product-img">
    <div class="img-wrapper">
        <img src="images/<?php echo $product['image']; ?>">
    </div>
</div>
</div>

<!-- RIGHT DETAILS -->
<div class="col-md-7">
<div class="product-box">

<h4 class="product-title"><?php echo $product['name']; ?></h4>

<p class="price">₹<?php echo number_format($product['price'],2); ?></p>

<p><?php echo $product['description']; ?></p>

<div class="buttons">

<button class="btn btn-warning add-to-cart"
data-id="<?php echo $product['id']; ?>">
Add to Cart
</button>

<button class="btn btn-success buy-now"
data-id="<?php echo $product['id']; ?>">
Buy Now
</button>

</div>

</div>
</div>

</div>

</div>

<script>
// ADD TO CART
document.querySelector(".add-to-cart").onclick = function(){
let id = this.dataset.id;

fetch("add_to_cart.php", {
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"product_id="+id
})
.then(()=> alert("Added to cart ✅"));
};

// BUY NOW
document.querySelector(".buy-now").onclick = function(){
let id = this.dataset.id;
window.location.href = "checkout.php?id=" + id;
};
</script>

<?php include("includes/footer.php"); ?>