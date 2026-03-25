<?php
session_start();
include("../config.php");

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "GrihaMart" && $password === "GrihaMart@123") {

        $_SESSION['admin'] = "admin";
        header("Location: dashboard.php");
        exit();

    } else {
        echo "<script>alert('Invalid Admin Credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background: black;
font-family:'Segoe UI',sans-serif;
}

/* LOGIN CARD */
.login-box{
background:white;
padding:30px;
border-radius:15px;
width:350px;
box-shadow:0 10px 30px rgba(0,0,0,0.2);
text-align:center;
}

.login-box h2{
margin-bottom:20px;
font-weight:600;
color:#1e293b;
}

/* INPUT */
.form-control{
border-radius:10px;
padding:10px;
}

/* BUTTON */
.btn-login{
background:#6366f1;
color:white;
border:none;
border-radius:10px;
padding:10px;
font-weight:500;
transition:0.3s;
}

.btn-login:hover{
background:#4f46e5;
transform:scale(1.02);
}

/* ICON */
.logo{
font-size:30px;
margin-bottom:10px;
}
</style>

</head>

<body>

<div class="login-box">

<div class="logo">🔐</div>
<h2>Admin Login</h2>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="login" class="btn btn-login w-100">
    Login
</button>

</form>

</div>

</body>
</html>