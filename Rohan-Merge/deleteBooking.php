<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

if (!isset($_GET["idBooking"])) {
    echo "<p>No booking selected.</p>";
    exit();
}

$idBooking = intval($_GET["idBooking"]);

$sql = "SELECT Booking.booking_id, User.user_fname, User.user_lname, Room.room_no, Booking.check_in, Booking.check_out, Booking.booking_status 
        FROM Booking 
        JOIN User ON Booking.user_id = User.user_id 
        JOIN Room ON Booking.room_id = Room.room_id 
        WHERE Booking.booking_id = $idBooking";

$detail = $conn->query($sql)->fetch_assoc();

if (!$detail) {
    echo "<p>Booking not found.</p>";
    exit();
}

if (isset($_POST["deleteBooking"])) {
    deleteBooking($conn, $idBooking);
    header("Location: viewBookings.php");
    exit();
}
?>

<div>
    <h2 class="centered-header">Delete Booking</h2>
</div>

<div class="main">
<form method="post">

    <p>User: <?php echo $detail['user_fname'] . " " . $detail['user_lname']; ?></p>
    <p>Room: <?php echo $detail['room_no']; ?></p>
    <p>Check-In: <?php echo $detail['check_in']; ?></p>
    <p>Check-Out: <?php echo $detail['check_out']; ?></p>
    <p>Status: <?php echo $detail['booking_status']; ?></p>

    <input type="submit" name="deleteBooking" value="Delete Booking">

</form>
</div>

</body>
</html>
