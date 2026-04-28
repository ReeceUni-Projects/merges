<?php
include("ownerAuth.php");
include("db_connect.php");

$totalRevenue = 0;
$totalPayments = 0;
$paidPayments = 0;
$unpaidPayments = 0;

$sqlTotals = "SELECT 
                COUNT(*) AS total_payments,
                SUM(amount) AS total_revenue,
                SUM(CASE WHEN status = 'Paid' THEN 1 ELSE 0 END) AS paid_payments,
                SUM(CASE WHEN status != 'Paid' THEN 1 ELSE 0 END) AS unpaid_payments
              FROM payments";

$resultTotals = mysqli_query($conn, $sqlTotals);

if ($resultTotals && mysqli_num_rows($resultTotals) > 0) {
    $totals = mysqli_fetch_assoc($resultTotals);
    $totalRevenue = $totals['total_revenue'] ?? 0;
    $totalPayments = $totals['total_payments'] ?? 0;
    $paidPayments = $totals['paid_payments'] ?? 0;
    $unpaidPayments = $totals['unpaid_payments'] ?? 0;
}

$revenueData = [];
$maxRevenue = 0;

$revenueByDate = mysqli_query($conn, "
    SELECT payment_date, SUM(amount) AS daily_total
    FROM payments
    WHERE status = 'Paid'
    GROUP BY payment_date
    ORDER BY payment_date DESC
    LIMIT 7
");

if ($revenueByDate && mysqli_num_rows($revenueByDate) > 0) {
    while ($row = mysqli_fetch_assoc($revenueByDate)) {
        $revenueData[] = $row;
        if ((float)$row['daily_total'] > $maxRevenue) {
            $maxRevenue = (float)$row['daily_total'];
        }
    }

    $revenueData = array_reverse($revenueData);
}

$topDescriptions = mysqli_query($conn, "
    SELECT description, COUNT(*) AS total_count, SUM(amount) AS total_amount
    FROM payments
    GROUP BY description
    ORDER BY total_amount DESC
    LIMIT 5
");

$recentPayments = mysqli_query($conn, "
    SELECT payment_date, description, amount, status
    FROM payments
    ORDER BY payment_date DESC, id DESC
    LIMIT 10
");

$totalStatusCount = $paidPayments + $unpaidPayments;
$paidPercent = ($totalStatusCount > 0) ? ($paidPayments / $totalStatusCount) * 100 : 0;
$unpaidPercent = ($totalStatusCount > 0) ? ($unpaidPayments / $totalStatusCount) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Reports - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .reports-container {
            width: 92%;
            max-width: 1300px;
            margin: 120px auto 50px auto;
        }

        .reports-title {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 36px;
        }

        .stats-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            min-width: 230px;
            border-radius: 14px;
            padding: 25px;
            color: white;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .stat-card h3 {
            margin: 0 0 12px 0;
            font-size: 18px;
        }

        .stat-card p {
            margin: 0;
            font-size: 30px;
            font-weight: bold;
        }

        .card-green {
            background: linear-gradient(135deg, #1f5f4a, #2d8a6a);
        }

        .card-blue {
            background: linear-gradient(135deg, #234e70, #3182ce);
        }

        .card-gold {
            background: linear-gradient(135deg, #9c6b00, #d69e2e);
        }

        .card-red {
            background: linear-gradient(135deg, #7b1e1e, #c53030);
        }

        .charts-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .report-box {
            flex: 1;
            min-width: 350px;
            background: rgba(255,255,255,0.97);
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
        }

        .report-box h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #1f2d2a;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 14px;
            height: 260px;
            padding: 15px 10px 0 10px;
            border-left: 2px solid #ccc;
            border-bottom: 2px solid #ccc;
        }

        .bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            height: 100%;
        }

        .bar {
            width: 100%;
            max-width: 60px;
            background: linear-gradient(to top, #1f5f4a, #48bb78);
            border-radius: 8px 8px 0 0;
            min-height: 10px;
            transition: 0.3s;
        }

        .bar-label {
            margin-top: 10px;
            font-size: 13px;
            text-align: center;
            color: #333;
        }

        .bar-value {
            font-size: 12px;
            margin-bottom: 8px;
            color: #174a39;
            font-weight: bold;
        }

        .status-chart {
            margin-top: 20px;
        }

        .status-line {
            margin-bottom: 18px;
        }

        .status-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-weight: bold;
            color: #222;
        }

        .status-bar-bg {
            width: 100%;
            height: 24px;
            background: #e5e5e5;
            border-radius: 30px;
            overflow: hidden;
        }

        .status-bar-fill {
            height: 100%;
        }

        .status-paid {
            background: linear-gradient(90deg, #1f5f4a, #38a169);
        }

        .status-unpaid {
            background: linear-gradient(90deg, #8b1e1e, #e53e3e);
        }

        .table-section {
            background: rgba(255,255,255,0.97);
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
            margin-bottom: 30px;
        }

        .table-section h3 {
            margin-top: 0;
            color: #1f2d2a;
        }

        .no-data {
            text-align: center;
            color: #666;
            padding: 15px 0;
        }

        .section-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .half-box {
            flex: 1;
            min-width: 400px;
        }
    </style>
</head>
<body>

<?php include("ownerNavbar.php"); ?>

<div class="reports-container">
    <h1 class="reports-title">Owner Reports</h1>

    <div class="stats-row">
        <div class="stat-card card-green">
            <h3>Total Revenue</h3>
            <p>£<?php echo number_format((float)$totalRevenue, 2); ?></p>
        </div>

        <div class="stat-card card-blue">
            <h3>Total Payments</h3>
            <p><?php echo (int)$totalPayments; ?></p>
        </div>

        <div class="stat-card card-gold">
            <h3>Paid Payments</h3>
            <p><?php echo (int)$paidPayments; ?></p>
        </div>

        <div class="stat-card card-red">
            <h3>Unpaid Payments</h3>
            <p><?php echo (int)$unpaidPayments; ?></p>
        </div>
    </div>

    <div class="charts-row">
        <div class="report-box">
            <h3>Revenue Over Last 7 Dates</h3>

            <?php if (!empty($revenueData)): ?>
                <div class="bar-chart">
                    <?php foreach ($revenueData as $row): ?>
                        <?php
                            $amount = (float)$row['daily_total'];
                            $height = ($maxRevenue > 0) ? ($amount / $maxRevenue) * 100 : 0;
                        ?>
                        <div class="bar-group">
                            <div class="bar-value">£<?php echo number_format($amount, 2); ?></div>
                            <div class="bar" style="height: <?php echo $height; ?>%;"></div>
                            <div class="bar-label"><?php echo ($row['payment_date']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-data">No revenue data found.</div>
            <?php endif; ?>
        </div>

        <div class="report-box">
            <h3>Payment Status Breakdown</h3>

            <div class="status-chart">
                <div class="status-line">
                    <div class="status-label">
                        <span>Paid</span>
                        <span><?php echo number_format($paidPercent, 1); ?>%</span>
                    </div>
                    <div class="status-bar-bg">
                        <div class="status-bar-fill status-paid" style="width: <?php echo $paidPercent; ?>%;"></div>
                    </div>
                </div>

                <div class="status-line">
                    <div class="status-label">
                        <span>Unpaid</span>
                        <span><?php echo number_format($unpaidPercent, 1); ?>%</span>
                    </div>
                    <div class="status-bar-bg">
                        <div class="status-bar-fill status-unpaid" style="width: <?php echo $unpaidPercent; ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-grid">
        <div class="table-section half-box">
            <h3>Top Services / Payment Types</h3>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Count</th>
                        <th>Revenue (£)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($topDescriptions && mysqli_num_rows($topDescriptions) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($topDescriptions)): ?>
                            <tr>
                                <td><?php echo ($row['description']); ?></td>
                                <td><?php echo (int)$row['total_count']; ?></td>
                                <td>£<?php echo number_format((float)$row['total_amount'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="no-data">No service data found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-section half-box">
            <h3>Recent Transactions</h3>
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
                            <td colspan="4" class="no-data">No recent transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>