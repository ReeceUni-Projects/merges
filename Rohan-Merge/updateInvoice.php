<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
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
$invoice = viewInvoice($conn, $idInvoice);

if (!$invoice) {
    echo "<p>Invoice not found.</p>";
    exit();
}

$i = $invoice[0];

if (isset($_POST["updateInvoice"])) {

    $amount      = $_POST["amount"];
    $issueDate   = $_POST["issue_date"];
    $dueDate     = $_POST["due_date"];
    $status      = $_POST["invoice_status"];

    updateInvoice($conn, $idInvoice, $amount, $issueDate, $dueDate, $status);

    header("Location: viewInvoices.php?booking_id={$i['booking_id']}");
    exit();
}
?>

<div>
    <h2 class="centered-header">Update Invoice</h2>
</div>

<div class="main">
<form method="post">

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" value="<?php echo $i['amount']; ?>" required>

    <label for="issue_date">Issue Date:</label>
    <input type="date" id="issue_date" name="issue_date" value="<?php echo $i['issue_date']; ?>" required>

    <label for="due_date">Due Date:</label>
    <input type="date" id="due_date" name="due_date" value="<?php echo $i['due_date']; ?>" required>

    <label for="invoice_status">Status:</label>
    <select id="invoice_status" name="invoice_status" required>
        <option value="Pending" <?php if ($i['invoice_status']=="Pending") echo "selected"; ?>>Pending</option>
        <option value="Paid" <?php if ($i['invoice_status']=="Paid") echo "selected"; ?>>Paid</option>
        <option value="Overdue" <?php if ($i['invoice_status']=="Overdue") echo "selected"; ?>>Overdue</option>
    </select>

    <input type="submit" name="updateInvoice" value="Update Invoice">

</form>
</div>

</body>
</html>
