<?php
session_start();
include '../config.php';

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password)){
        echo "<script>alert('Please fill all fields');</script>";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                echo "<script>
                        alert('Login Successful!');
                        window.location='../index.php';
                      </script>";
                exit();

            } else {
                echo "<script>alert('Wrong Password');</script>";
            }

        } else {
            echo "<script>alert('Email Not Found');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background: linear-gradient(135deg,#667eea,#764ba2);
font-family:'Segoe UI',sans-serif;
}

/* LOGIN BOX */
.login-box{
background:#fff;
padding:30px;
border-radius:16px;
width:350px;
box-shadow:0 15px 40px rgba(0,0,0,0.2);
text-align:center;
}

/* TITLE */
.login-box h3{
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
background:#667eea;
color:white;
border:none;
border-radius:10px;
padding:10px;
font-weight:500;
transition:0.3s;
}

.btn-login:hover{
background:#5a67d8;
transform:scale(1.03);
}

/* LINK */
.login-box a{
text-decoration:none;
font-weight:500;
color:#667eea;
}

.login-box a:hover{
text-decoration:underline;
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

<div class="logo">👤</div>
<h3>Customer Login</h3>

<form method="POST">

<input type="email" name="email" class="form-control mb-3" placeholder="Email Address" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" name="login" class="btn btn-login w-100">
    Login
</button>

</form>

<p class="mt-3">
Don't have an account? 
<a href="register.php">Register here</a>
</p>

</div>

</body>
</html>