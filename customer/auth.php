<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#f8f9fa; /* ✅ off-white */
}

/* Card */
.box{
background:white;
padding:40px;
border-radius:16px;
text-align:center;
color:#333;
width:360px;
box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

/* Title */
.box h2{
margin-bottom:10px;
font-weight:600;
}

.box p{
font-size:14px;
color:#777;
margin-bottom:25px;
}

/* Buttons */
.btn{
display:block;
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:10px;
cursor:pointer;
font-size:15px;
font-weight:500;
transition:0.3s;
}

/* Register */
.register{
background:#6c63ff;
color:white;
}

.register:hover{
background:#574fd6;
}

/* Login */
.login{
background:#e9ecef;
color:#333;
}

.login:hover{
background:#dcdfe3;
}

</style>

</head>

<body>

<div class="box">

<img src="../images/logo2.png" alt="GrihaMart Logo" style="width:80px; margin-bottom:10px;">

<h2>Welcome to GrihaMart</h2>
<p>Handmade products crafted with love</p>

<a href="register.php">
<button class="btn register">Create Account</button>
</a>

<a href="login.php">
<button class="btn login">Already have an account? Login</button>
</a>

</div>

</body>
</html>