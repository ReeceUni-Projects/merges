<?php
include("auth.php");
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM meal_orders WHERE user_id='$user_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Meal History</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php require 'navbar.php'; ?>

<div class="container">

<h2>Meal Order History</h2>

<table>
<tr>
    <th>Date</th>
    <th>Meal</th>
    <th>Quantity</th>
    <th>Total (£)</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
        <td>{$row['order_date']}</td>
        <td>{$row['meal_type']}</td>
        <td>{$row['quantity']}</td>
        <td>£{$row['total_amount']}</td>
    </tr>";
}
?>

</table>

</div>

</body>
</html>