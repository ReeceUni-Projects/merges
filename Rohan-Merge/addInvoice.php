<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Invoice</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php
include("NavBar.php");
include("db_connect.php");
require_once("functions.php");

$bookingID = isset($_GET["booking_id"]) ? intval($_GET["booking_id"]) : 0;

if (isset($_POST["addInvoice"])) {

    $bookingID   = $_POST["bookingID"];
    $amount      = $_POST["amount"];
    $issueDate   = $_POST["issue_date"];
    $dueDate     = $_POST["due_date"];
    $status      = $_POST["invoice_status"];

    addInvoice($conn, $bookingID, $amount, $issueDate, $dueDate, $status);

    header("Location: viewInvoices.php?booking_id=$bookingID");
    exit();
}
?>

<div>
    <h2 class="centered-header">Add Invoice</h2>
</div>

<div class="main">
<form method="post">

    <input type="hidden" name="bookingID" value="<?php echo $bookingID; ?>">

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" required>

    <label for="issue_date">Issue Date:</label>
    <input type="date" id="issue_date" name="issue_date" required>

    <label for="due_date">Due Date:</label>
    <input type="date" id="due_date" name="due_date" required>

    <label for="invoice_status">Status:</label>
    <select id="invoice_status" name="invoice_status" required>
        <option value="" disabled selected>Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Paid">Paid</option>
        <option value="Overdue">Overdue</option>
    </select>

    <input type="submit" name="addInvoice" value="Add Invoice">

</form>
</div>

</body>
</html>
