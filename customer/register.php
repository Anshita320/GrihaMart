<?php
session_start();
include '../config.php';

if (isset($_POST['register'])) {

    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);

    // Password check
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match');</script>";
        exit();
    }

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already registered! Please login.');</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $sql = "INSERT INTO users (name, email, password) 
            VALUES ('$name', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {

        // 🔥 AUTO LOGIN AFTER REGISTER
        $user_id = mysqli_insert_id($conn);
        $_SESSION['user_id'] = $user_id;

        echo "<script>
                alert('Registration Successful!');
                window.location='../index.php';
              </script>";
        exit();

    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f5f7fa;
}

.register-box{
    max-width:400px;
    margin:auto;
    margin-top:80px;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="register-box">

<h3 class="text-center mb-4">Create Account</h3>

<form method="POST">

<input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>

<input type="email" name="email" class="form-control mb-3" placeholder="Email Address" required>

<input type="password" name="new_password" class="form-control mb-3" placeholder="Password" required>

<input type="password" name="confirm_password" class="form-control mb-3" placeholder="Confirm Password" required>

<button type="submit" name="register" class="btn btn-dark w-100">
Register
</button>

</form>

<p class="text-center mt-3">
Already have an account? 
<a href="login.php">Login here</a>
</p>

</div>

</body>
</html>