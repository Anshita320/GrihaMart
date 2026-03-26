<?php
include("config.php");
include("includes/header.php");

$cat_id = $_GET['cat'];
?>

<style>

    .section-title{
        text-align: center;
        font-size: 35px;
    }

    /* Subcategory Card */
.subcategory-card{
background:#f2ffe6;
padding:10px;
border-radius:12px;
transition:0.3s;
height: 350px;
font-size: 22px;
}

.subcategory-card:hover{
transform:scale(1.05);
box-shadow:0 8px 20px rgba(0,0,0,0.1);
}

.subcategory-card img{
width:100%;
height:120px;
object-fit:cover;
border-radius:10px;
height: 300px;
}
</style>
<div class="container-fluid px-3 mt-4">

<h4 class="section-title"> Explore Subcategories</h4>

<div class="row g-3">

<?php
$sub = mysqli_query($conn,"SELECT * FROM subcategories WHERE category_id='$cat_id'");

while($row=mysqli_fetch_assoc($sub)){
?>

<div class="col-md-3 col-6">

<a href="products.php?sub=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">

<div class="subcategory-card text-center">

<img src="images/subcategories/<?php echo $row['image']; ?>" 
onerror="this.src='images/noimage.png'">

<h6 class="mt-2"><?php echo $row['name']; ?></h6>

</div>

</a>

</div>

<?php } ?>

</div>
</div>

<?php include("includes/footer.php"); ?>