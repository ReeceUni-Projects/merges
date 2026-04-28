<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

if (isset($_POST["addBooking"])) {

    $userID        = $_POST["userID"];
    $roomID        = $_POST["roomID"];
    $bookingDate   = $_POST["booking_date"];
    $checkIn       = $_POST["check_in"];
    $checkOut      = $_POST["check_out"];
    $paymentCycle  = $_POST["payment_cycle"];
    $status        = $_POST["booking_status"];

    addBooking($conn, $userID, $roomID, $bookingDate, $checkIn, $checkOut, $paymentCycle, $status);

    header("Location: viewBookings.php");
    exit();
}
?>

<div>
    <h2 class="centered-header">Add New Booking</h2>
</div>

<div class="main">
<form method="post">

    <label for="userID">User:</label>
    <select id="userID" name="userID" required>
        <option value="" disabled selected>Select User</option>
        <?php
        $users = $conn->query("SELECT user_id, user_fname, user_lname FROM User");
        while ($u = $users->fetch_assoc()) {
            echo "<option value='{$u['user_id']}'>{$u['user_fname']} {$u['user_lname']}</option>";
        }
        ?>
    </select>

    <label for="roomID">Room:</label>
    <select id="roomID" name="roomID" required>
        <option value="" disabled selected>Select Room</option>
        <?php
        $rooms = $conn->query("SELECT room_id, room_no FROM Room");
        while ($r = $rooms->fetch_assoc()) {
            echo "<option value='{$r['room_id']}'>Room {$r['room_no']}</option>";
        }
        ?>
    </select>

    <label for="booking_date">Booking Date:</label>
    <input type="date" id="booking_date" name="booking_date" required>

    <label for="check_in">Check-In Date:</label>
    <input type="date" id="check_in" name="check_in" required>

    <label for="check_out">Check-Out Date:</label>
    <input type="date" id="check_out" name="check_out" required>

    <label for="payment_cycle">Payment Cycle:</label>
    <select id="payment_cycle" name="payment_cycle" required>
        <option value="" disabled selected>Payment Cycle</option>
        <option value="Weekly">Weekly</option>
        <option value="Monthly">Monthly</option>
    </select>

    <label for="booking_status">Status:</label>
    <select id="booking_status" name="booking_status" required>
        <option value="" disabled selected>Status</option>
        <option value="Pending">Pending</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Cancelled">Cancelled</option>
    </select>

    <input type="submit" name="addBooking" value="Add Booking">

</form>
</div>

</body>
</html>
