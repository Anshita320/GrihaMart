<?php
session_start();
include("config.php");
include("includes/header.php");

if(!isset($_GET['sub'])){
    echo "<h3 class='text-center mt-5 text-danger'>No Subcategory Selected</h3>";
    include("includes/footer.php");
    exit();
}

$sub_id = intval($_GET['sub']);
$products = mysqli_query($conn, "SELECT * FROM products WHERE subcategory_id='$sub_id'");
?>

<style>


body{
    background:#f2ffe6;
    font-family: Arial, sans-serif;
}

/* CARD */
.product-card{
    background:white;
    border-radius:12px;
    padding:15px;
    width:100%;
    min-height: 450px;
    max-width:500px;   /* 🔥 control size */
    margin:auto;
    transition:0.3s;
    position:relative;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    overflow:hidden;   /* 🔥 prevent overflow */
}

.product-card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 20px rgba(0,0,0,0.15);
}

/* IMAGE */
.product-img{
    width:100%;
    height:350px;   /* 🔥 perfect size */
    overflow:hidden;
    border-radius:10px;
}

.product-img img{
    width:100%;
    height:100%;
    object-fit:cover;   /* 🔥 main fix */
    display:block;
    transition:0.3s;
}

/*.product-card:hover .product-img img{
    transform:scale(1.05);
}
*/
/* TITLE */
.product-title{
    font-size:14px;
    font-weight:600;
    margin:8px 0 4px;
}

/* PRICE */
.price{
    font-size:14px;
    color:#2a5298;
    font-weight:700;
    margin-bottom:8px;
}

/* BUTTONS */
.actions{
    display:flex;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
}

.actions .btn{
    font-size:11px;
    padding:5px 8px;
    border-radius:6px;
    border:none;
    cursor:pointer;
}

/* BUTTON COLORS */
.btn-secondary{
    background:#000000;
}

.btn-warning{
    background:#ffc107;
    color:black;
}

.btn-success{
    background:#28a745;
    color:white;
}

/* ❤️ WISHLIST */
.wishlist-icon{
    position:absolute;
    top:8px;
    right:8px;
    background:white;
    padding:5px;
    border-radius:50%;
    font-size:14px;
    color:#bbb;
    cursor:pointer;
}

.wishlist-icon.active{
    color:red;
}
/* 🔥 MOBILE RESPONSIVE */
@media(max-width:768px){

/* GRID GAP FIX */
.row{
    gap:10px;
}

/* CARD SIZE FIX */
.product-card{
    min-height:auto;
    max-width:100%;
    padding:10px;
}

/* IMAGE SIZE FIX */
.product-img{
    height:160px;   /* 🔥 compact */
}

/* TITLE */
.product-title{
    font-size:13px;
    margin:6px 0;
}

/* PRICE */
.price{
    font-size:13px;
}

/* BUTTONS STACK */
.actions{
    flex-direction:column;
    gap:5px;
}

/* BUTTON FULL WIDTH */
.actions .btn{
    width:100%;
    font-size:11px;
    padding:6px;
}

/* WISHLIST ICON */
.wishlist-icon{
    top:6px;
    right:6px;
    font-size:12px;
    padding:4px;
}

}
</style>

<div class="container mt-4">

<h4 class="text-center mb-4">🛍️ Products</h4>

<div class="row g-3">

<?php
if(mysqli_num_rows($products) > 0){
while($row = mysqli_fetch_assoc($products)){
?>

<div class="col-md-3 col-6">

<div class="product-card">

    <!-- ❤️ WISHLIST -->
    <?php
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    $check_wish = mysqli_query($conn,
    "SELECT * FROM wishlist WHERE user_id='$user_id' AND product_id='".$row['id']."'");
    ?>

    <i class="wishlist-icon <?php if(mysqli_num_rows($check_wish)>0) echo 'active'; ?>"
    data-id="<?php echo $row['id']; ?>">
    ❤
    </i>

    <!-- ✅ IMAGE WRAPPER (IMPORTANT FIX) -->
    <div class="product-img">
        <img src="images/<?php echo !empty($row['image']) ? $row['image'] : 'noimage.png'; ?>">
    </div>

    <h6 class="product-title">
        <?php echo htmlspecialchars($row['name'] ?? 'No Name'); ?>
    </h6>

    <p class="price">
        ₹<?php echo isset($row['price']) ? number_format($row['price'],2) : '0'; ?>
    </p>

    <!-- ✅ FIXED CLASS NAME -->
    <div class="actions">

        <a href="product.php?id=<?php echo $row['id']; ?>"
        class="btn btn-secondary">View Details</a>

        <button class="btn btn-warning add-to-cart"
        data-id="<?php echo $row['id']; ?>">
        Add to Cart
        </button>

        <button class="btn btn-success buy-now"
        data-id="<?php echo $row['id']; ?>">
        Buy Now
        </button>

    </div>

</div>

</div>

<?php
}
}else{
echo "<h5 class='text-center'>No products found</h5>";
}
?>

</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

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

// BUY NOW
document.querySelectorAll(".buy-now").forEach(btn=>{
btn.addEventListener("click", function(){

let id = this.dataset.id;
window.location.href = "checkout.php?id=" + id;

});
});

// ❤️ WISHLIST
document.querySelectorAll(".wishlist-icon").forEach(icon=>{
icon.addEventListener("click", function(){

let el = this;
let id = el.dataset.id;

fetch("wishlist.php?id=" + id)
.then(res=>res.text())
.then(data=>{

data = data.trim();

if(data === "login_required"){
alert("Login first 😅");
return;
}

if(data === "added"){
el.classList.add("active");
}
else if(data === "removed"){
el.classList.remove("active");
}

});

});
});

});
</script>

<?php include("includes/footer.php"); ?>