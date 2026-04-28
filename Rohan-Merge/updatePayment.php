<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Payment</title>
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
$payment = viewPayment($conn, $idPayment);

if (!$payment) {
    echo "<p>Payment not found.</p>";
    exit();
}

$p = $payment[0];

if (isset($_POST["updatePayment"])) {

    $amount        = $_POST["amount"];
    $paymentDate   = $_POST["payment_date"];
    $method        = $_POST["payment_method"];
    $status        = $_POST["payment_status"];

    updatePayment($conn, $idPayment, $amount, $paymentDate, $method, $status);

    header("Location: viewPayments.php?booking_id={$p['booking_id']}");
    exit();
}
?>

<div>
    <h2 class="centered-header">Update Payment</h2>
</div>

<div class="main">
<form method="post">

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" value="<?php echo $p['amount']; ?>" required>

    <label for="payment_date">Payment Date:</label>
    <input type="date" id="payment_date" name="payment_date" value="<?php echo $p['payment_date']; ?>" required>

    <label for="payment_method">Payment Method:</label>
    <select id="payment_method" name="payment_method" required>
        <option value="Card" <?php if ($p['payment_method']=="Card") echo "selected"; ?>>Card</option>
        <option value="Cash" <?php if ($p['payment_method']=="Cash") echo "selected"; ?>>Cash</option>
        <option value="Bank Transfer" <?php if ($p['payment_method']=="Bank Transfer") echo "selected"; ?>>Bank Transfer</option>
    </select>

    <label for="payment_status">Status:</label>
    <select id="payment_status" name="payment_status" required>
        <option value="Pending" <?php if ($p['payment_status']=="Pending") echo "selected"; ?>>Pending</option>
        <option value="Paid" <?php if ($p['payment_status']=="Paid") echo "selected"; ?>>Paid</option>
        <option value="Failed" <?php if ($p['payment_status']=="Failed") echo "selected"; ?>>Failed</option>
    </select>

    <input type="submit" name="updatePayment" value="Update Payment">

</form>
</div>

</body>
</html>
