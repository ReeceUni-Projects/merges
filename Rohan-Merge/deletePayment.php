<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Payment</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

if (!isset($_GET["idPayment"])) {
    echo "<p>No payment selected.</p>";
    exit();
}

$idPayment = intval($_GET["idPayment"]);

$sql = "SELECT payment_id, booking_id, amount, payment_date, payment_method, payment_status 
        FROM Payment 
        WHERE payment_id = $idPayment";

$detail = $conn->query($sql)->fetch_assoc();

if (!$detail) {
    echo "<p>Payment not found.</p>";
    exit();
}

if (isset($_POST["deletePayment"])) {
    deletePayment($conn, $idPayment);
    header("Location: viewPayments.php?booking_id={$detail['booking_id']}");
    exit();
}
?>

<div>
    <h2 class="centered-header">Delete Payment</h2>
</div>

<div class="main">
<form method="post">

    <p>Amount: £<?php echo $detail['amount']; ?></p>
    <p>Date: <?php echo $detail['payment_date']; ?></p>
    <p>Method: <?php echo $detail['payment_method']; ?></p>
    <p>Status: <?php echo $detail['payment_status']; ?></p>

    <input type="submit" name="deletePayment" value="Delete Payment">

</form>
</div>

</body>
</html>
