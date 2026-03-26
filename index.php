<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: customer/auth.php");
    exit();
}

include("config.php");
include("includes/header.php");
?>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins', sans-serif;
}

html, body{
background:#f2ffe6;
width: 100%;
margin: 0;
padding: 0;
overflow-x:hidden;
}

/* Container Fix */
.container{
max-width:100%;
padding-left: 10px;
padding-right: 10px;
}

.container-fluid{
padding-left:10px;
padding-right:10px;
}

.row{
margin-left: 0;
margin-right: 0;
}

/* Banner */
.carousel-item img{
width:100%;
height:250px;
object-fit:cover;
border-radius:12px;
}

/* Section Title */
.section-title{
text-align:center;
font-weight:600;
margin-bottom:15px;
font-size:44px;
}

/* Category */
.category-card{
background:white;
padding:12px;
border-radius:12px;
transition:0.3s;
text-align:center;
height: auto;
width: 100%;
}

.category-card:hover{
transform:scale(1.05);
box-shadow:0 8px 20px rgba(0,0,0,0.1);
background: #c9ff99;
}

.category-card img{
height:180px;
width:100%;
object-fit:cover;
border-radius:10px;
}

.category-card h6{
margin-top:10px;
font-size:18px;
color:  #1a3300;
}

/* Product Scroll */
.scroll-products{
    display:flex;
    overflow-x:auto;
    gap:20px;
    padding:20px 15px;     /* 🔥 reduce padding */
    scroll-behavior:smooth;
    align-items:center;    /* 🔥 center cards vertically */
    background:#ccffcc;
}

.scroll-products::-webkit-scrollbar{
display:none;
}

/* Product */
.product-box{
min-width:260px;
height:370px;
background:white;
padding:30px;
border-radius:15px;
text-align:center;
transition:0.3s;
display:flex;
flex-direction:column;
justify-content:space-between;
}

/* Hover effect */
.product-box:hover{
transform:translateY(-6px);
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* Image */
.product-box img{
height:220px;
width: 100%;
object-fit:cover;
margin-bottom:15px;
}

/* Product Name */
.product-box p{
font-size:15px;
margin:5px 0;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

/* Price highlight */
.product-box b{
font-size:16px;
color:#2a5298;
}
/* Big Banner */
.big-banner{
    width:100%;
     /* 🔥 center me controlled width */
    margin:30px auto;
    overflow:hidden;
}

.big-banner img{
    width:100%;
    height:560px;          /* 🔥 controlled height (not too big) */
    object-fit:cover;    /* 🔥 FULL IMAGE SHOW (no cut) */
    border-radius:12px;
    background:#fff;   
   display: block;  /* 🔥 empty space clean lage */
}

/* Women Box */
.women-box{
background:linear-gradient(135deg,#ff9a9e,#fad0c4);
border-radius:14px;
width: 100%;
font-size: 25px;
}

/* ===== MOBILE RESPONSIVE IMPROVEMENTS ===== */
@media (max-width:768px){

/* Fix large heading */
.section-title{
font-size:18px !important;
}

/* Category card fix */
.category-card{
height:auto !important;
padding:8px;
}

.category-card img{
height:100px !important;
}

.category-card h6{
font-size:14px !important;
}

/* Product scroll improve */
.scroll-products{
    padding:15px !important;
    align-items:center;
}

/* 🔥 TRENDING PRODUCTS FIX */
.product-box{
    min-width:140px !important;
    height:230px !important;      /* 🔥 height kam */
    padding:8px !important;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    align-items:center;
}

/* IMAGE FIX */
.product-box img{
    height:120px !important;      /* 🔥 smaller */
    width:100% !important;
    object-fit:cover;
    border-radius:8px;
}

/* TEXT FIX */
.product-box p{
    font-size:12px !important;
    margin:3px 0;
}

/* PRICE */
.product-box b{
    font-size:13px !important;
}

/* Banner fix */
.carousel-item img{
height:180px !important;
}

.big-banner img{
height:150px !important;
}

/* Women section fix */
.women-box{
font-size:16px !important;
padding:20px !important;
}

.women-box h3{
font-size:18px !important;
}

/* Grid spacing fix */
.col-6{
padding:5px !important;
}

/* Prevent overflow */
body{
overflow-x:hidden;
}



}
</style>



<!-- ================= BANNER ================= -->
<div class="container-fluid px-2">

<div id="homeBanner" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">

<?php
$banners = mysqli_query($conn,"SELECT * FROM banners WHERE status=1");
$first=true;

while($row=mysqli_fetch_assoc($banners)){
?>

<div class="carousel-item <?php if($first){echo 'active'; $first=false;} ?>">
<img src="images/<?php echo $row['image']; ?>">
</div>

<?php } ?>

</div>
</div>

</div>


<!-- ================= CATEGORIES ================= -->
<div class="container px-2">

<h4 class="section-title"> Explore Handmade Categories</h4>

<div class="row g-3">

<?php
$categories = [
["Handmade Jewellery","jewelry.jpeg","1"],
["Candles & Fragrance","candles.jpeg","2"],
["Knitted & Crochet","crochet.jpeg","3"],
["Wooden Crafts","wooden.jpeg","4"],
["Art & Paintings","art.jpeg","5"],
["Home Decor","decor.jpeg","6"],
["Beauty","beauty.jpeg","7"],
["Paper Crafts","paper.jpeg","8"],
["Fabric Products","fabric.jpeg","9"],
["Toys & Kids","toys.jpeg","10"],
["Gifts & Personalized","gift.jpg","11"],
["Homemade Food","food.jpeg","12"],
["Spiritual Crafts","spiritual.jpeg","13"],
["Stationery","stationery.jpeg","14"]
];

foreach($categories as $cat){
?>

<div class="col-md-3 col-6">

<div class="category-card">

<a href="subcategory.php?cat=<?php echo $cat[2]; ?>" style="text-decoration:none;color:black;">

<img src="images/categories/<?php echo $cat[1]; ?>"
onerror="this.src='images/noimage.png'">

<h6><?php echo $cat[0]; ?></h6>

</a>

</div>

</div>

<?php } ?>

</div>
</div>


<!-- ================= BIG BANNER 1 ================= -->
<div class="container-fluid mt-4 big-banner">
<img src="images/banner.jpeg">
</div>


<!-- ================= TRENDING ================= -->
<div class="container mt-4">

<h4 class="section-title">🔥 Trending Products</h4>

<div class="scroll-products">

<?php
$products = mysqli_query($conn,"SELECT * FROM products ORDER BY RAND() LIMIT 10");

while($row=mysqli_fetch_assoc($products)){
?>

<div class="product-box">

<a href="product.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">

<img src="images/<?php echo $row['image']; ?>">

<p><?php echo $row['name']; ?></p>
<p><b>₹<?php echo $row['price']; ?></b></p>

</a>

</div>

<?php } ?>

</div>
</div>


<!-- ================= BIG BANNER 2 ================= -->
<div class="container-fluid mt-4 big-banner">
<img src="images/banner4.png">
</div>


<!-- ================= WOMEN ================= -->
<div class="container mt-4 mb-4">

<div class="card p-5 text-center women-box">

<h3>💜 Support Women Entrepreneurs</h3>

<p style="max-width:600px;margin:auto;">
GrihaMart empowers home-based women entrepreneurs.  
Shop handmade products crafted with love.
</p>

<a href="search.php" class="btn btn-dark mt-3">Explore</a>

</div>

</div>


<?php include("includes/footer.php"); ?>