<?php
session_start();
require 'navbar.php';
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['room_type'])) {
    echo "<script>alert('No room selected'); window.location='roomGallery.php';</script>";
    exit;
}

$room_type = $_POST['room_type'];

$prices = [
    "Single Room" => 100,
    "Double Room" => 400,
    "Triple Room" => 500
];

$price = $prices[$room_type];
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Room</title>
<link rel="stylesheet" href="style.css">

<style>
.booking-box{
    width:450px;
    margin:150px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    position:relative;
    z-index:1;
}

.booking-box h2{
    text-align:center;
    margin-bottom:20px;
}

.booking-box p{
    font-size:16px;
    margin-bottom:10px;
}

.booking-box button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
}

.booking-box button:hover{
    background:#27ae60;
}
</style>
</head>

<body>

<div class="booking-box">

<h2>Confirm Booking</h2>

<p><strong>Room Type:</strong> <?php echo $room_type; ?></p>
<p><strong>Monthly Price:</strong> £<?php echo $price; ?></p>

<form method="POST" action="confirmRoom.php">
    <input type="hidden" name="room_type" value="<?php echo $room_type; ?>">
    <input type="hidden" name="price" value="<?php echo $price; ?>">
    <button type="submit">Confirm Booking</button>
</form>

</div>

</body>
</html>
