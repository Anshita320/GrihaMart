<?php
session_start();
include "includes/header.php";
include "config.php";

if(!isset($_SESSION['user_id'])){
header("Location: customer/login.php");
exit();
}

$user_id = $_SESSION['user_id'];

$name="";
$email="";
$phone="";

/* FETCH USER DATA */

$result = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$row = mysqli_fetch_assoc($result);

if($row){
$name = $row['name'];
$email = $row['email'];
$phone = $row['phone'];
}

/* SAVE PROFILE */

if(isset($_POST['save_profile'])){

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);

if($name=="" || $email=="" || $phone==""){
echo "<script>alert('Please fill all details');</script>";
}else{

mysqli_query($conn,"UPDATE users 
SET name='$name',
email='$email',
phone='$phone'
WHERE id='$user_id'");

/* SESSION UPDATE */

$_SESSION['user_name'] = $name;
$_SESSION['user_email'] = $email;

echo "<script>
alert('Profile Updated Successfully');
window.location='profile.php';
</script>";

}

}

?>

<!DOCTYPE html>
<html>
<head>

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f1f3f6;
}

.profile-box{
background:white;
padding:25px;
border-radius:6px;
}

.sidebar{
background:white;
padding:20px;
border-radius:6px;
}

.sidebar a{
display:block;
padding:10px;
text-decoration:none;
color:black;
}

.sidebar a:hover{
background:#f5f5f5;
}

.form-control{
height:45px;
}

.edit-btn{
margin-left:10px;
}

</style>

</head>

<body>

<div class="container mt-4">

<div class="row">
    <?php include "includes/account_sidebar.php"; ?>




<!-- PROFILE -->

<div class="col-md-9">

<div class="profile-box">

<h4>
Personal Information
<button type="button" id="editBtn" class="btn btn-sm btn-outline-primary edit-btn">
Edit
</button>
</h4>

<br>

<form method="POST">

<div class="mb-3">

<label class="form-label">Full Name</label>

<input type="text"
name="name"
id="name"
class="form-control"
value="<?php echo $name; ?>"
placeholder="Enter your full name"
readonly>

</div>


<div class="mb-3">

<label class="form-label">Email Address</label>

<input type="email"
name="email"
id="email"
class="form-control"
value="<?php echo $email; ?>"
placeholder="Enter your email"
readonly>

</div>


<div class="mb-3">

<label class="form-label">Mobile Number</label>

<input type="text"
name="phone"
id="phone"
class="form-control"
value="<?php echo $phone; ?>"
placeholder="Enter mobile number"
readonly>

</div>


<button type="submit"
name="save_profile"
id="saveBtn"
class="btn btn-primary"
style="display:none;">
Save
</button>

</form>

</div>

</div>

</div>

</div>

<script>

let editBtn = document.getElementById("editBtn");
let saveBtn = document.getElementById("saveBtn");

let name = document.getElementById("name");
let email = document.getElementById("email");
let phone = document.getElementById("phone");

editBtn.onclick = function(){

name.removeAttribute("readonly");
email.removeAttribute("readonly");
phone.removeAttribute("readonly");

saveBtn.style.display="inline-block";
editBtn.style.display="none";

}

</script>

<?php include "includes/footer.php"; ?>

</body>
</html>
