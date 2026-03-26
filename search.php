<?php
session_start();
include("config.php");
include("includes/header.php");

// QUERY LOGIC
if(isset($_GET['category'])){
    $category = $_GET['category'];
    $sql = "SELECT * FROM products WHERE category='$category'";
}
else if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
}
else{
    echo "<h4 class='text-center mt-5'>No Products Found</h4>";
    exit();
}

$result = mysqli_query($conn,$sql);
?>

<style>

/* BODY */
body{ background:#f2ffe6; }

/* GRID */
.col-lg-2-4{ width:20%; }
@media(max-width:992px){ .col-lg-2-4{ width:25%; } }
@media(max-width:768px){ .col-lg-2-4{ width:50%; } }

/* CARD */
.product-card{
background:white;
border-radius:16px;
padding:10px;
transition:0.3s;
position:relative;
}
.product-card:hover{
transform:translateY(-8px);
box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

/* IMAGE */
.product-img{
    width:100%;
    height:150px;
    overflow:hidden;
    border-radius:10px;
}

.product-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.product-card:hover img{
transform:scale(1.05);
}

/* TITLE + PRICE */
.product-title{
font-size:16px;   /* 🔥 bigger */
font-weight:600;
margin:8px 0;
text-align:center;
min-height:45px;
}

.price{
font-size:18px;
font-weight:bold;
text-align:center;  /* 🔥 center */
margin-bottom:8px;
}

.actions{
display:flex;
justify-content:center;
gap:6px;
flex-wrap:wrap;
}

.actions .btn{
font-size:12px;
padding:6px 10px;
border-radius:8px;
}
/* ❤️ WISHLIST */
.wishlist-icon {
    position:absolute;
    top:10px;
    right:10px;
    background:white;
    padding:7px;
    border-radius:50%;
    cursor:pointer;
    font-size:18px;
    color:#bbb;
    transition:0.3s;
}

.wishlist-icon.active {
    color:red;
    transform:scale(1.2);
}

/* BUTTON COLORS */
.btn-success{ background:#28a745; border:none; }
.btn-warning{ background:#ffb300; border:none; }

/* ===== MOBILE RESPONSIVE ===== */
@media(max-width:768px){

/* grid spacing */
.row{
    gap:10px;
}

/* card compact */
.product-card{
    padding:8px;
}

/* image smaller */
.product-img img{
    height:140px;
}

/* title smaller */
.product-title{
    font-size:13px;
    min-height:auto;
}

/* price smaller */
.price{
    font-size:14px;
}

/* buttons stack properly */
.actions{
    flex-direction:column;
    gap:5px;
}

/* button full width */
.actions .btn{
    width:100%;
    font-size:11px;
    padding:5px;
}

/* wishlist icon adjust */
.wishlist-icon{
    top:6px;
    right:6px;
    font-size:14px;
    padding:5px;
}

}
</style>

<div class="container-fluid px-3 mt-4">

<h4 class="text-center mb-4">🔍 Search Results</h4>

<div class="row g-3">

<?php
if(mysqli_num_rows($result) > 0){
while($row=mysqli_fetch_assoc($result)){
?>

<div class="col-lg-2-4 col-md-3 col-6">

<div class="product-card">

<div class="product-img">

<img src="images/<?php echo $row['image']; ?>" 
onerror="this.src='images/noimage.png'">

<!-- ❤️ Wishlist -->
<?php
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$check_wish = mysqli_query($conn, 
"SELECT * FROM wishlist WHERE user_id='$user_id' AND product_id='".$row['id']."'");
?>

<i class="wishlist-icon <?php if(mysqli_num_rows($check_wish)>0) echo 'active'; ?>" 
data-id="<?php echo $row['id']; ?>">
❤
</i>

</div>

<div class="product-details">

<h5 class="product-title">
<?php echo htmlspecialchars($row['name']); ?>
</h5>

<p class="price">
₹<?php echo number_format((float)preg_replace('/[^0-9.]/','',$row['price']), 2); ?>
</p>

<div class="actions">

<a href="product.php?id=<?php echo $row['id']; ?>" 
class="btn btn-outline-dark btn-sm">View Details</a>

<button class="btn btn-warning btn-sm add-to-cart" 
data-id="<?php echo $row['id']; ?>">Add to Cart</button>

<button class="btn btn-success btn-sm buy-now" 
data-id="<?php echo $row['id']; ?>">Buy Now</button>

</div>

</div>

</div>

</div>

<?php
}
}else{
echo "<h5 class='text-center'>No Products Found</h5>";
}
?>

</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

// ADD TO CART
document.querySelectorAll(".add-to-cart").forEach(btn=>{
btn.addEventListener("click", function(){

let id = this.getAttribute("data-id");

console.log("Product ID:", id);

fetch("add_to_cart.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "product_id=" + encodeURIComponent(id)
})
.then(res=>res.text())
.then(data=>{
    console.log("Response:", data);

    if(data.trim() === "added"){
        alert("Added to cart ✅");
    } else {
        alert("Error: " + data);
    }
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