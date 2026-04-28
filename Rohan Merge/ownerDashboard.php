<?php
include("ownerAuth.php");
include("db_connect.php");

$totalRevenue = 0;
$paymentCount = 0;
$paidCount = 0;

$result1 = mysqli_query($conn, "SELECT SUM(amount) AS total_revenue, COUNT(*) AS total_payments FROM payments");
if ($result1) {
    $row1 = mysqli_fetch_assoc($result1);
    $totalRevenue = $row1['total_revenue'] ?? 0;
    $paymentCount = $row1['total_payments'] ?? 0;
}

$result2 = mysqli_query($conn, "SELECT COUNT(*) AS paid_count FROM payments WHERE status='Paid'");
if ($result2) {
    $row2 = mysqli_fetch_assoc($result2);
    $paidCount = $row2['paid_count'] ?? 0;
}

$recentPayments = mysqli_query($conn, "SELECT payment_date, description, amount, status FROM payments ORDER BY payment_date DESC, id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1200px;
            margin: 140px auto 50px auto;
        }

        .dashboard-title {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .stats-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            min-width: 240px;
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #1f2d2a;
        }

        .stat-card p {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #174a39;
        }

        .table-box {
            background: rgba(255,255,255,0.97);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .table-box h3 {
            margin-top: 0;
            color: #1f2d2a;
        }

        .owner-actions {
            margin-top: 20px;
            text-align: right;
        }

        .logout-btn {
            display: inline-block;
            background: #8b1e1e;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 6px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background: #6d1616;
        }
    </style>
</head>
<body>

<?php include("ownerNavbar.php"); ?>

<div class="dashboard-container">
    <h1 class="dashboard-title">Owner Financial Dashboard</h1>

    <div class="stats-row">
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <p>£<?php echo number_format((float)$totalRevenue, 2); ?></p>
        </div>

        <div class="stat-card">
            <h3>Total Payments</h3>
            <p><?php echo (int)$paymentCount; ?></p>
        </div>

        <div class="stat-card">
            <h3>Paid Transactions</h3>
            <p><?php echo (int)$paidCount; ?></p>
        </div>
    </div>

    <div class="table-box">
        <h3>Recent Payments</h3>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount (£)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recentPayments && mysqli_num_rows($recentPayments) > 0): ?>
                    <?php while ($payment = mysqli_fetch_assoc($recentPayments)): ?>
                        <tr>
                            <td><?php echo ($payment['payment_date']); ?></td>
                            <td><?php echo ($payment['description']); ?></td>
                            <td>£<?php echo number_format((float)$payment['amount'], 2); ?></td>
                            <td><?php echo ($payment['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="owner-actions">
            <a href="ownerLogout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</div>

</body>
</html