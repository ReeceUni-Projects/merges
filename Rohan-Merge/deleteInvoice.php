<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Invoice</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

if (!isset($_GET["idInvoice"])) {
    echo "<p>No invoice selected.</p>";
    exit();
}

$idInvoice = intval($_GET["idInvoice"]);

$sql = "SELECT invoice_id, booking_id, amount, issue_date, due_date, invoice_status 
        FROM Invoice 
        WHERE invoice_id = $idInvoice";

$detail = $conn->query($sql)->fetch_assoc();

if (!$detail) {
    echo "<p>Invoice not found.</p>";
    exit();
}

if (isset($_POST["deleteInvoice"])) {
    deleteInvoice($conn, $idInvoice);
    header("Location: viewInvoices.php?booking_id={$detail['booking_id']}");
    exit();
}
?>

<div>
    <h2 class="centered-header">Delete Invoice</h2>
</div>

<div class="main">
<form method="post">

    <p>Amount: £<?php echo $detail['amount']; ?></p>
    <p>Issue Date: <?php echo $detail['issue_date']; ?></p>
    <p>Due Date: <?php echo $detail['due_date']; ?></p>
    <p>Status: <?php echo $detail['invoice_status']; ?></p>

    <input type="submit" name="deleteInvoice" value="Delete Invoice">

</form>
</div>

</body>
</html>
