<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");

$bookingID = isset($_GET["booking_id"]) ? intval($_GET["booking_id"]) : 0;
?>

<div>
    <h2 class="centered-header">View Payments</h2>
</div>

<div class="main">
<?php
$records_per_page = 5;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($current_page < 1) {
    $current_page = 1;
}

$offset = ($current_page - 1) * $records_per_page;

$total_query = "SELECT COUNT(*) as total FROM Payment WHERE booking_id = $bookingID";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row["total"];
$total_pages = ceil($total_records / $records_per_page);

$select_query = "SELECT payment_id, amount, payment_date, payment_method, payment_status 
                 FROM Payment 
                 WHERE booking_id = $bookingID
                 ORDER BY payment_id DESC 
                 LIMIT $records_per_page OFFSET $offset";

$result = $conn->query($select_query);

echo "<table>";
echo "
<thead>
<tr>
    <td>ID</td>
    <td>Amount</td>
    <td>Date</td>
    <td>Method</td>
    <td>Status</td>
    <td colspan='2'>Action</td>
</tr>
</thead>
";

while ($row = $result->fetch_assoc()) {
    echo "
    <tbody>
    <tr>
        <td>{$row['payment_id']}</td>
        <td>£{$row['amount']}</td>
        <td>{$row['payment_date']}</td>
        <td>{$row['payment_method']}</td>
        <td>{$row['payment_status']}</td>

        <td><a href='updatePayment.php?idPayment={$row['payment_id']}'><button>Update</button></a></td>
        <td><a href='deletePayment.php?idPayment={$row['payment_id']}'><button>Delete</button></a></td>
    </tr>
    </tbody>
    ";
}

echo "</table>";

echo "<div class='pagination'>";

if ($current_page > 1) {
    $prev_page = $current_page - 1;
    echo "<a href='?booking_id=$bookingID&page=$prev_page'>Previous</a>";
}

for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $current_page) {
        echo "<strong>$i</strong>";
    } else {
        echo "<a href='?booking_id=$bookingID&page=$i'>$i</a>";
    }
}

if ($current_page < $total_pages) {
    $next_page = $current_page + 1;
    echo "<a href='?booking_id=$bookingID&page=$next_page'>Next</a>";
}

echo "</div>";

$conn->close();
?>
</div>

</body>
</html>
