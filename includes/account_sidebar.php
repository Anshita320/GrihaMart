<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    body{
    background:#f2ffe6;
}
.sidebar{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.sidebar h6{
color:#777;
margin-top:15px;
font-size:13px;
text-transform:uppercase;
}
.col-md-3{
max-width:280px;
}
.sidebar a{
display:block;
padding:10px 12px;
margin-bottom:5px;
text-decoration:none;
color:#333;
border-radius:6px;
transition:0.2s;
font-size:14px;
}

.sidebar a:hover{
background:#f1f3f6;
color:#000;
}

/* ACTIVE LINK */
.sidebar a.active{
background:#ffc107;
color:#000;
font-weight:600;
}

/* USER BOX */
.user-box{
margin-bottom:15px;
}

.user-box h5{
margin:0;
font-size:16px;
}

.user-box small{
color:#777;
}
</style>

<div class="col-md-3 col-12 mb-3">

<div class="sidebar">

<!-- USER -->
<div class="user-box">
<small>Hello,</small>
<h5><?php echo $_SESSION['user_name']; ?></h5>
</div>

<hr>

<!-- ORDERS -->
<a href="my_orders.php"
class="<?php if($current_page=='my_orders.php') echo 'active'; ?>">
🛍️ My Orders
</a>

<!-- WISHLIST -->
<a href="wishlist_page.php"
class="<?php if($current_page=='wishlist_page.php') echo 'active'; ?>">
❤️ Wishlist
</a>

<h6>Account Settings</h6>

<!-- PROFILE -->
<a href="profile.php"
class="<?php if($current_page=='profile.php') echo 'active'; ?>">
👤 My Profile
</a>

<!-- ADDRESS -->
<a href="manage_address.php"
class="<?php if($current_page=='manage_address.php') echo 'active'; ?>">
📍 Manage Address
</a>

<hr>

<!-- LOGOUT -->
<a href="customer/logout.php">
🚪 Logout
</a>

</div>

</div>