<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking</title>
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
$booking = viewBooking($conn, $idBooking);

if (!$booking) {
    echo "<p>Booking not found.</p>";
    exit();
}

$b = $booking[0];

if (isset($_POST["updateBooking"])) {

    $userID        = $_POST["userID"];
    $roomID        = $_POST["roomID"];
    $bookingDate   = $_POST["booking_date"];
    $checkIn       = $_POST["check_in"];
    $checkOut      = $_POST["check_out"];
    $paymentCycle  = $_POST["payment_cycle"];
    $status        = $_POST["booking_status"];

    updateBooking($conn, $idBooking, $userID, $roomID, $bookingDate, $checkIn, $checkOut, $paymentCycle, $status);

    header("Location: viewBookings.php");
    exit();
}
?>

<div>
    <h2 class="centered-header">Update Booking</h2>
</div>

<div class="main">
<form method="post">

    <label for="userID">User:</label>
    <select id="userID" name="userID" required>
        <?php
        $users = $conn->query("SELECT user_id, user_fname, user_lname FROM User");
        while ($u = $users->fetch_assoc()) {
            $sel = ($u['user_id'] == $b['user_id']) ? "selected" : "";
            echo "<option value='{$u['user_id']}' $sel>{$u['user_fname']} {$u['user_lname']}</option>";
        }
        ?>
    </select>

    <label for="roomID">Room:</label>
    <select id="roomID" name="roomID" required>
        <?php
        $rooms = $conn->query("SELECT room_id, room_no FROM Room");
        while ($r = $rooms->fetch_assoc()) {
            $sel = ($r['room_id'] == $b['room_id']) ? "selected" : "";
            echo "<option value='{$r['room_id']}' $sel>Room {$r['room_no']}</option>";
        }
        ?>
    </select>

    <label for="booking_date">Booking Date:</label>
    <input type="date" id="booking_date" name="booking_date" value="<?php echo $b['booking_date']; ?>" required>

    <label for="check_in">Check-In Date:</label>
    <input type="date" id="check_in" name="check_in" value="<?php echo $b['check_in']; ?>" required>

    <label for="check_out">Check-Out Date:</label>
    <input type="date" id="check_out" name="check_out" value="<?php echo $b['check_out']; ?>" required>

    <label for="payment_cycle">Payment Cycle:</label>
    <select id="payment_cycle" name="payment_cycle" required>
        <option value="Weekly" <?php if ($b['payment_cycle']=="Weekly") echo "selected"; ?>>Weekly</option>
        <option value="Monthly" <?php if ($b['payment_cycle']=="Monthly") echo "selected"; ?>>Monthly</option>
    </select>

    <label for="booking_status">Status:</label>
    <select id="booking_status" name="booking_status" required>
        <option value="Pending" <?php if ($b['booking_status']=="Pending") echo "selected"; ?>>Pending</option>
        <option value="Confirmed" <?php if ($b['booking_status']=="Confirmed") echo "selected"; ?>>Confirmed</option>
        <option value="Cancelled" <?php if ($b['booking_status']=="Cancelled") echo "selected"; ?>>Cancelled</option>
    </select>

    <input type="submit" name="updateBooking" value="Update Booking">

</form>
</div>

</body>
</html>
