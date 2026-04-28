<?php
include("auth.php");
include("db_connect.php");

$user_id = $_SESSION['user_id'];

mysqli_query($conn, "
    UPDATE payments 
    SET status = 'Overdue'
    WHERE status = 'Pending'
    AND payment_date < DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)
");

$sql = "SELECT payment_date, description, amount, status 
        FROM payments 
        WHERE user_id = '$user_id' 
        ORDER BY payment_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>LuckyNest - Payment History</title>
    <link rel="stylesheet" href="style.css">

    <style>
    body {
        font-family: Arial;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 140px auto 50px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .paid {
        color: #1f7a4d;
        font-weight: bold;
    }

    .pending {
        color: #d69e2e;
        font-weight: bold;
    }

    .overdue {
        color: #c53030;
        font-weight: bold;
    }
    </style>
</head>

<body>

<?php require 'navbar.php'; ?>

<div class="container">

<h2>Payment History</h2>

<table>
<tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount (£)</th>
    <th>Status</th>
</tr>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $statusClass = strtolower($row['status']);

        echo "<tr>
                <td>{$row['payment_date']}</td>
                <td>" . ($row['description']) . "</td>
                <td>£" . number_format((float)$row['amount'], 2) . "</td>
                <td class='{$statusClass}'>{$row['status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No payments found</td></tr>";
}
?>

</table>

</div>

</body>
</html>