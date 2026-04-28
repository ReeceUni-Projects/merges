<?php
include("auth.php");
require 'navbar.php';
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, room_type, price, booking_date 
        FROM room_bookings 
        WHERE user_id = '$user_id'
        ORDER BY booking_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings - LuckyNest</title>
<link rel="stylesheet" href="style.css">

<style>
.bookings-container{
    width:80%;
    margin:150px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    position:relative;
    z-index:1;
}

.bookings-container h1{
    text-align:center;
    margin-bottom:25px;
}

.booking-card{
    background:#f8f8f8;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-left:5px solid #2ecc71;
}

.booking-info{
    font-size:16px;
}

.cancel-btn{
    background:#e74c3c;
    color:white;
    padding:10px 18px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
}

.cancel-btn:hover{
    background:#c0392b;
}
</style>
</head>

<body>

<div class="bookings-container">

<h1>My Room Bookings</h1>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p style="text-align:center; font-size:18px;">You have no active room bookings.</p>
<?php endif; ?>

<?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="booking-card">
        <div class="booking-info">
            <strong><?php echo $row['room_type']; ?></strong><br>
            Price: £<?php echo $row['price']; ?><br>
            Booked on: <?php echo $row['booking_date']; ?>
        </div>

        <form action="cancelRoom.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
            <button class="cancel-btn">Cancel Booking</button>
        </form>
    </div>
<?php endwhile; ?>

</div>

</body>
</html>
