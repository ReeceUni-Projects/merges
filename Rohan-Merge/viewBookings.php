<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
?>

<div>
    <h2 class="centered-header">View Bookings</h2>
</div>

<div class="main">
<?php
$records_per_page = 5;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($current_page < 1) {
    $current_page = 1;
}

$offset = ($current_page - 1) * $records_per_page;

$total_query = "SELECT COUNT(*) as total FROM Booking";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row["total"];
$total_pages = ceil($total_records / $records_per_page);

$select_query = "SELECT Booking.booking_id, User.user_fname, User.user_lname, Room.room_no, Booking.booking_date, Booking.check_in, Booking.check_out, Booking.payment_cycle, Booking.booking_status 
                 FROM Booking 
                 JOIN User ON Booking.user_id = User.user_id 
                 JOIN Room ON Booking.room_id = Room.room_id 
                 ORDER BY Booking.booking_id DESC 
                 LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($select_query);

echo "<table>";
echo "
<thead>
<tr>
    <td>ID</td>
    <td>User</td>
    <td>Room No.</td>
    <td>Date</td>
    <td>Check In</td>
    <td>Check Out</td>
    <td>Payment Cycle</td>
    <td>Booking Status</td>
    <td colspan='3'>Action</td>
</tr>
</thead>
";

while ($row = $result->fetch_assoc()) {
    echo "
    <tbody>
    <tr>
        <td>{$row['booking_id']}</td>
        <td>{$row['user_fname']} {$row['user_lname']}</td>
        <td>{$row['room_no']}</td>
        <td>{$row['booking_date']}</td>
        <td>{$row['check_in']}</td>
        <td>{$row['check_out']}</td>
        <td>{$row['payment_cycle']}</td>
        <td>{$row['booking_status']}</td>

        <td><a href='updateBooking.php?idBooking={$row['booking_id']}'><button>Update</button></a></td>
        <td><a href='deleteBooking.php?idBooking={$row['booking_id']}'><button>Delete</button></a></td>
        <td><a href='viewPayments.php?booking_id={$row['booking_id']}'><button>Payments</button></a></td>
    </tr>
    </tbody>
    ";
}

echo "</table>";

echo "<div class='pagination'>";

if ($current_page > 1) {
    $prev_page = $current_page - 1;
    echo "<a href='?page=$prev_page'>Previous</a>";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $current_page) {
        echo "<strong>$i</strong>";
    } else {
        echo "<a href='?page=$i'>$i</a>";
    }
}

if ($current_page < $total_pages) {
    $next_page = $current_page + 1;
    echo "<a href='?page=$next_page'>Next</a>";
}

echo "</div>";

$conn->close();
?>
</div>

</body>
</html>
