<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['booking_id'])) {
    echo "<script>alert('Invalid booking'); window.location='myBookings.php';</script>";
    exit;
}

$booking_id = $_POST['booking_id'];

$sql = "DELETE FROM room_bookings 
        WHERE id = '$booking_id' AND user_id = '$user_id'";

mysqli_query($conn, $sql);

echo "<script>alert('Booking cancelled successfully'); window.location='myBookings.php';</script>";
?>
