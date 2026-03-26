<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>GrihaMart</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
/* NAVBAR */
.navbar{
  background:linear-gradient(45deg,#1e3c72,#2a5298);
  padding:10px 20px;
}

/* WRAPPER */
.header-wrap{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:20px;
}

/* LOGO */
.navbar-brand{
  font-size:26px;
  font-weight:bold;
  margin:0;
  color:white !important;
}

.logo-img{
  height:60px;
  width:auto;
  object-fit:contain;
}

/* SEARCH */
.search-box{
  display:flex;
  flex:1;
  max-width:600px;
}

.search-input{
  flex:1;
  border-radius:30px 0 0 30px;
  border:none;
  padding:10px;
  font-size:16px;
}

.search-btn{
  border-radius:0 30px 30px 0;
  padding:8px 20px;
}

/* RIGHT SIDE */
.right-section{
  display:flex;
  align-items:center;
  gap:15px;
}

/* PROFILE */
.profile-btn{
  color:white;
  font-size:18px;
  display:flex;
  align-items:center;
  gap:5px;
}

.profile-btn:hover{
  color:white;
}

/* CART */
.cart-btn{
  border-radius:25px;
  padding:6px 15px;
  font-size:15px;
}

/* DROPDOWN */
.dropdown-menu{
  border-radius:10px;
}

.dropdown-menu .dropdown-item:hover{
  background-color:#ffc107;
  color:black;
}

/* 🔥 RESPONSIVE (MOBILE FIX) */
@media(max-width:768px){

  .header-wrap{
    flex-direction:column;
    align-items:center;
    gap:10px;
  }

  .navbar-brand{
    text-align:center;
  }

  .logo-img{
    height:40px;
  }

  .search-box{
    width:100%;
    max-width:100%;
  }

  .right-section{
    justify-content:space-between;
    width:100%;
  }

  .profile-btn{
    font-size:14px;
  }

  .cart-btn{
    font-size:14px;
    padding:5px 12px;
  }

}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow">

<div class="container-fluid header-wrap">

<!-- LOGO -->
<a class="navbar-brand d-flex align-items-center" href="/grihamart/index.php">

<img src="/grihamart/images/logo2.png" alt="logo" class="logo-img">

<span class="ms-2">GrihaMart</span>

</a>

<!-- SEARCH -->
<form class="search-box" action="/grihamart/search.php" method="GET">

<input class="form-control search-input"
type="search"
name="search"
placeholder="Search products..."
required>

<button class="btn btn-warning search-btn">
Search
</button>

</form>

<!-- RIGHT SIDE -->
<div class="right-section">

<?php if(isset($_SESSION['user_name'])) { ?>



<div class="dropdown">

<a class="profile-btn dropdown-toggle text-decoration-none"
href="#"

data-bs-toggle="dropdown">

<i class="bi bi-person-circle"></i>
<?php echo $_SESSION['user_name']; ?>

</a>

<ul class="dropdown-menu dropdown-menu-end">

<li><a class="dropdown-item" href="/grihamart/profile.php">My Profile</a></li>
<li><a class="dropdown-item" href="/grihamart/my_orders.php">My Orders</a></li>
<li><a class="dropdown-item" href="/grihamart/manage_address.php">Saved Address</a></li>
<li><a class="dropdown-item" href="/grihamart/wishlist_page.php">Wishlist</a></li>
<li><a class="dropdown-item" href="/grihamart/customer/logout.php">Logout</a></li>

</ul>

</div>

<?php } else { ?>

<a href="/grihamart/customer/login.php" class="btn btn-light me-2">Login</a>
<a href="/grihamart/customer/register.php" class="btn btn-warning">Register</a>

<?php } ?>


<!-- CART -->

<a href="/grihamart/cart.php" class="btn btn-warning cart-btn">
🛒 Cart
</a>

</div>

</div>

</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>