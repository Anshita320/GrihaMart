<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* DATA */
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];

$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as revenue FROM orders WHERE status='Delivered'"))['revenue'];
if (!$total_revenue) $total_revenue = 0;

$pending   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='Pending'"))['total'];
$delivered = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='Delivered'"))['total'];
$cancelled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status='Cancelled'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:#f1f5f9;
}

/* SIDEBAR */
.sidebar{
width:240px;
height:100vh;
position:fixed;
background:#1e293b;
padding-top:20px;
color:white;
}

.sidebar h3{
text-align:center;
margin-bottom:30px;
}

.sidebar a{
display:block;
padding:12px 20px;
color:#cbd5f5;
text-decoration:none;
transition:0.3s;
}

.sidebar a:hover{
background:#334155;
color:white;
}

/* MAIN */
.main{
margin-left:240px;
padding:20px;
}

/* TOPBAR */
.topbar{
display:flex;
justify-content:space-between;
align-items:center;
background:white;
padding:12px 20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
margin-bottom:20px;
}

/* CARDS */
.card-box{
border-radius:15px;
padding:20px;
color:white;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
transition:0.3s;
}

.card-box:hover{
transform:translateY(-5px);
}

.bg1{background:#6366f1;}
.bg2{background:#10b981;}
.bg3{background:#f59e0b;}
.bg4{background:#3b82f6;}
.bg5{background:#ef4444;}

.card-title{
font-size:14px;
opacity:0.9;
}

.card-value{
font-size:28px;
font-weight:bold;
margin-top:5px;
}

/* BUTTON */
.logout-btn{
background:#ef4444;
color:white;
border:none;
padding:6px 12px;
border-radius:8px;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>🛒 Admin</h3>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="add_product.php">➕ Add Product</a>
    <a href="view_products.php">📦 View Products</a>
    <a href="view_orders.php">🧾 Orders</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">
    <h4>Dashboard</h4>
    <span>Welcome Admin 👋</span>
</div>

<!-- CARDS -->
<div class="row g-4">

<div class="col-md-4">
<div class="card-box bg1">
<div class="card-title">Total Orders</div>
<div class="card-value"><?php echo $total_orders; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-box bg2">
<div class="card-title">Total Revenue</div>
<div class="card-value">₹<?php echo $total_revenue; ?></div>
</div>
</div>

<div class="col-md-4">
<div class="card-box bg3">
<div class="card-title">Pending Orders</div>
<div class="card-value"><?php echo $pending; ?></div>
</div>
</div>

<div class="col-md-6">
<div class="card-box bg4">
<div class="card-title">Delivered Orders</div>
<div class="card-value"><?php echo $delivered; ?></div>
</div>
</div>

<div class="col-md-6">
<div class="card-box bg5">
<div class="card-title">Cancelled Orders</div>
<div class="card-value"><?php echo $cancelled; ?></div>
</div>
</div>

</div>

</div>

</body>
</html>