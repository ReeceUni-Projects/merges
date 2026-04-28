<?php
session_start();
include("db_connect.php"); // your database connection

// Get logged in user ID
$user_id = $_SESSION['user_id'];

// Get user details from database
$sql = "SELECT name, email, phone, address FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>LuckyNest - Profile</title>

<style>

body{
    font-family: Arial;
    background-color:#f4f4f4;
}

.profile-container{
    width:60%;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
}

.details{
    margin-top:30px;
}

.detail-row{
    margin-bottom:15px;
}

.label{
    font-weight:bold;
}

.update-btn{
    display:block;
    width:200px;
    margin:30px auto 0 auto;
    padding:12px;
    background:#2c3e50;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    text-align:center;
}

.update-btn:hover{
    background:#34495e;
}

</style>
</head>

<body>

<div class="profile-container">

<h2>Account Details</h2>

<div class="details">

<div class="detail-row">
<span class="label">Name:</span>
<?php echo $user['name']; ?>
</div>

<div class="detail-row">
<span class="label">Email:</span>
<?php echo $user['email']; ?>
</div>

<div class="detail-row">
<span class="label">Phone:</span>
<?php echo $user['phone']; ?>
</div>

<div class="detail-row">
<span class="label">Address:</span>
<?php echo $user['address']; ?>
</div>

</div>

<a href="update_profile.php">
<button class="update-btn">Update Information</button>
</a>

</div>

</body>
</html>