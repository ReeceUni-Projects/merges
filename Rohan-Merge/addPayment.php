<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

$bookingID = isset($_GET["booking_id"]) ? intval($_GET["booking_id"]) : 0;

if (isset($_POST["addPayment"])) {

    $bookingID     = $_POST["bookingID"];
    $amount        = $_POST["amount"];
    $paymentDate   = $_POST["payment_date"];
    $method        = $_POST["payment_method"];
    $status        = $_POST["payment_status"];

    addPayment($conn, $bookingID, $amount, $paymentDate, $method, $status);

    header("Location: viewPayments.php?booking_id=$bookingID");
    exit();
}
?>

<div>
    <h2 class="centered-header">Add Payment</h2>
</div>

<div class="main">
<form method="post">

    <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" required>

    <label for="payment_date">Payment Date:</label>
    <input type="date" id="payment_date" name="payment_date" required>

    <label for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method" required>
        <option value="" disabled selected>Select Method</option>
        <option value="obt">Online Bank Transfer</option>
        <option value="cc">Debit/Credit Card</option>
        <option value="upi">UPI / Digital Wallets</option>
        <option value="cash">Cash</option>

    </select>

    <label for="payment_status">Status:</label>
    <select id="payment_status" name="payment_status" required>
        <option value="" disabled selected>Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Paid">Paid</option>
        <option value="Failed">Failed</option>
    </select>

    <input type="submit" name="addPayment" value="Add Payment">

</form>
</div>

</body>
</html>
