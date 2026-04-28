<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$room_type = $_POST['room_type'];
$price     = $_POST['price'];
$date      = date("Y-m-d");

$sql = "INSERT INTO room_bookings (user_id, room_type, price, booking_date)
        VALUES ('$user_id', '$room_type', '$price', '$date')";
mysqli_query($conn, $sql);

echo "<script>alert('Room booked successfully!'); window.location='dashboard.php';</script>";
?>
