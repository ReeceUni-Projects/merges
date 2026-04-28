<?php
include("ownerAuth.php");
include("db_connect.php");

mysqli_query($conn, "
    UPDATE payments 
    SET status = 'Overdue'
    WHERE status = 'Pending'
    AND payment_date < DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)
");

$result = mysqli_query($conn, "
    SELECT
        SUM(CASE WHEN status = 'Paid' THEN amount ELSE 0 END) AS paid_total,
        SUM(CASE WHEN status = 'Pending' THEN amount ELSE 0 END) AS pending_total,
        SUM(CASE WHEN status = 'Overdue' THEN amount ELSE 0 END) AS overdue_total,
        SUM(amount) AS total_revenue,
        AVG(amount) AS average_payment
    FROM payments
");

$row = mysqli_fetch_assoc($result);

$paid = $row['paid_total'] ?? 0;
$pending = $row['pending_total'] ?? 0;
$overdue = $row['overdue_total'] ?? 0;
$totalRevenue = $row['total_revenue'] ?? 0;
$averagePayment = $row['average_payment'] ?? 0;

$thisMonthRevenue = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(amount) AS total 
    FROM payments 
    WHERE status = 'Paid'
    AND MONTH(payment_date) = MONTH(CURRENT_DATE())
    AND YEAR(payment_date) = YEAR(CURRENT_DATE())
"))['total'] ?? 0;

$lastMonthRevenue = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(amount) AS total 
    FROM payments 
    WHERE status = 'Paid'
    AND MONTH(payment_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
    AND YEAR(payment_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
"))['total'] ?? 0;

if ($lastMonthRevenue > 0) {
    $growthPercent = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
} else {
    $growthPercent = 0;
}

$growthSymbol = ($growthPercent >= 0) ? "▲" : "▼";
$growthClass = ($growthPercent >= 0) ? "growth-up" : "growth-down";

$compare = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT
        SUM(CASE WHEN status='Paid' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE()) 
            AND YEAR(payment_date)=YEAR(CURRENT_DATE())
            THEN amount ELSE 0 END) AS this_paid,

        SUM(CASE WHEN status='Pending' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE()) 
            AND YEAR(payment_date)=YEAR(CURRENT_DATE())
            THEN amount ELSE 0 END) AS this_pending,

        SUM(CASE WHEN status='Overdue' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE()) 
            AND YEAR(payment_date)=YEAR(CURRENT_DATE())
            THEN amount ELSE 0 END) AS this_overdue,

        SUM(CASE WHEN status='Paid' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(payment_date)=YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
            THEN amount ELSE 0 END) AS last_paid,

        SUM(CASE WHEN status='Pending' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(payment_date)=YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
            THEN amount ELSE 0 END) AS last_pending,

        SUM(CASE WHEN status='Overdue' 
            AND MONTH(payment_date)=MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
            AND YEAR(payment_date)=YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
            THEN amount ELSE 0 END) AS last_overdue
    FROM payments
"));

$thisPaid = $compare['this_paid'] ?? 0;
$thisPending = $compare['this_pending'] ?? 0;
$thisOverdue = $compare['this_overdue'] ?? 0;

$lastPaid = $compare['last_paid'] ?? 0;
$lastPending = $compare['last_pending'] ?? 0;
$lastOverdue = $compare['last_overdue'] ?? 0;

$highestCompare = max(
    $thisPaid, $thisPending, $thisOverdue,
    $lastPaid, $lastPending, $lastOverdue,
    1
);

$monthlyData = mysqli_query($conn, "
    SELECT 
        DATE_FORMAT(payment_date, '%b %Y') AS month_name,
        SUM(amount) AS monthly_total
    FROM payments
    WHERE status = 'Paid'
    GROUP BY YEAR(payment_date), MONTH(payment_date)
    ORDER BY YEAR(payment_date), MONTH(payment_date)
    LIMIT 12
");

$months = [];
$highestMonth = 1;

if ($monthlyData) {
    while ($m = mysqli_fetch_assoc($monthlyData)) {
        $months[] = $m;
        if ($m['monthly_total'] > $highestMonth) {
            $highestMonth = $m['monthly_total'];
        }
    }
}

$maxStatus = max($paid, $pending, $overdue, 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Statistics - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .finance-container {
            width: 92%;
            max-width: 1300px;
            margin: 120px auto 50px auto;
        }

        .finance-title {
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
            min-width: 220px;
            padding: 25px;
            border-radius: 14px;
            color: white;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
            text-align: center;
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

        .green { background: linear-gradient(135deg, #1f5f4a, #2d8a6a); }
        .gold { background: linear-gradient(135deg, #9c6b00, #d69e2e); }
        .red { background: linear-gradient(135deg, #7b1e1e, #c53030); }
        .blue { background: linear-gradient(135deg, #234e70, #3182ce); }

        .growth-up {
            color: #38a169;
            font-weight: bold;
        }

        .growth-down {
            color: #c53030;
            font-weight: bold;
        }

        .chart-box {
            background: rgba(255,255,255,0.97);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
            margin-bottom: 30px;
        }

        .chart-box h2 {
            margin-top: 0;
            color: #1f2d2a;
            text-align: center;
        }

        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 18px;
            height: 300px;
            padding: 20px;
            border-left: 2px solid #ccc;
            border-bottom: 2px solid #ccc;
        }

        .bar-group {
            flex: 1;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
        }

        .bar-value {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #174a39;
        }

        .bar {
            width: 70%;
            max-width: 70px;
            background: linear-gradient(to top, #1f5f4a, #48bb78);
            border-radius: 8px 8px 0 0;
            min-height: 8px;
        }

        .bar-label {
            margin-top: 10px;
            font-size: 13px;
            color: #333;
        }

        .status-row {
            margin-bottom: 20px;
        }

        .status-label {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .status-bg {
            background: #ddd;
            height: 28px;
            border-radius: 30px;
            overflow: hidden;
        }

        .status-fill {
            height: 100%;
            border-radius: 30px;
        }

        .paid-fill { background: #1f5f4a; }
        .pending-fill { background: #d69e2e; }
        .overdue-fill { background: #c53030; }

        .compare-chart {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 25px;
        }

        .compare-group {
            text-align: center;
        }

        .compare-bars {
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 12px;
            border-bottom: 2px solid #ccc;
        }

        .compare-bar {
            width: 45px;
            border-radius: 8px 8px 0 0;
            min-height: 8px;
        }

        .this-month-bar {
            background: #1f5f4a;
        }

        .last-month-bar {
            background: #d69e2e;
        }

        .compare-label {
            margin-top: 10px;
            font-weight: bold;
        }

        .compare-value {
            font-size: 12px;
            margin-bottom: 6px;
        }

        .legend {
            text-align: center;
            margin-top: 20px;
        }

        .legend span {
            display: inline-block;
            margin: 0 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<?php include("ownerNavbar.php"); ?>

<div class="finance-container">

    <h1 class="finance-title">Finance Statistics</h1>

    <div class="stats-row">
        <div class="stat-card green">
            <h3>Total Paid</h3>
            <p>£<?php echo number_format((float)$paid, 2); ?></p>
        </div>

        <div class="stat-card gold">
            <h3>Total Pending</h3>
            <p>£<?php echo number_format((float)$pending, 2); ?></p>
        </div>

        <div class="stat-card red">
            <h3>Total Overdue</h3>
            <p>£<?php echo number_format((float)$overdue, 2); ?></p>
        </div>

        <div class="stat-card blue">
            <h3>Average Payment</h3>
            <p>£<?php echo number_format((float)$averagePayment, 2); ?></p>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card green">
            <h3>This Month</h3>
            <p>£<?php echo number_format((float)$thisMonthRevenue, 2); ?></p>
        </div>

        <div class="stat-card blue">
            <h3>Last Month</h3>
            <p>£<?php echo number_format((float)$lastMonthRevenue, 2); ?></p>
        </div>

        <div class="stat-card gold">
            <h3>Total Revenue</h3>
            <p>£<?php echo number_format((float)$totalRevenue, 2); ?></p>
        </div>

        <div class="stat-card blue">
            <h3>Monthly Growth</h3>
            <p class="<?php echo $growthClass; ?>">
                <?php echo $growthSymbol; ?> <?php echo number_format(abs($growthPercent), 1); ?>%
            </p>
        </div>
    </div>

    <div class="chart-box">
        <h2>Paid Revenue by Month</h2>

        <?php if (!empty($months)): ?>
            <div class="bar-chart">
                <?php foreach ($months as $month): ?>
                    <?php
                        $amount = (float)$month['monthly_total'];
                        $height = ($amount / $highestMonth) * 100;
                    ?>
                    <div class="bar-group">
                        <div class="bar-value">£<?php echo number_format($amount, 2); ?></div>
                        <div class="bar" style="height: <?php echo $height; ?>%;"></div>
                        <div class="bar-label"><?php echo ($month['month_name']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center;">No monthly revenue data found.</p>
        <?php endif; ?>
    </div>

    <div class="chart-box">
        <h2>Payment Status Breakdown</h2>

        <div class="status-row">
            <div class="status-label">
                <span>Paid</span>
                <span>£<?php echo number_format((float)$paid, 2); ?></span>
            </div>
            <div class="status-bg">
                <div class="status-fill paid-fill" style="width: <?php echo ($paid / $maxStatus) * 100; ?>%;"></div>
            </div>
        </div>

        <div class="status-row">
            <div class="status-label">
                <span>Pending</span>
                <span>£<?php echo number_format((float)$pending, 2); ?></span>
            </div>
            <div class="status-bg">
                <div class="status-fill pending-fill" style="width: <?php echo ($pending / $maxStatus) * 100; ?>%;"></div>
            </div>
        </div>

        <div class="status-row">
            <div class="status-label">
                <span>Overdue</span>
                <span>£<?php echo number_format((float)$overdue, 2); ?></span>
            </div>
            <div class="status-bg">
                <div class="status-fill overdue-fill" style="width: <?php echo ($overdue / $maxStatus) * 100; ?>%;"></div>
            </div>
        </div>
    </div>

    <div class="chart-box">
        <h2>This Month vs Last Month</h2>

        <div class="compare-chart">

            <div class="compare-group">
                <div class="compare-bars">
                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$thisPaid, 2); ?></div>
                        <div class="compare-bar this-month-bar" style="height: <?php echo ($thisPaid / $highestCompare) * 100; ?>%;"></div>
                    </div>

                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$lastPaid, 2); ?></div>
                        <div class="compare-bar last-month-bar" style="height: <?php echo ($lastPaid / $highestCompare) * 100; ?>%;"></div>
                    </div>
                </div>
                <div class="compare-label">Paid</div>
            </div>

            <div class="compare-group">
                <div class="compare-bars">
                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$thisPending, 2); ?></div>
                        <div class="compare-bar this-month-bar" style="height: <?php echo ($thisPending / $highestCompare) * 100; ?>%;"></div>
                    </div>

                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$lastPending, 2); ?></div>
                        <div class="compare-bar last-month-bar" style="height: <?php echo ($lastPending / $highestCompare) * 100; ?>%;"></div>
                    </div>
                </div>
                <div class="compare-label">Pending</div>
            </div>

            <div class="compare-group">
                <div class="compare-bars">
                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$thisOverdue, 2); ?></div>
                        <div class="compare-bar this-month-bar" style="height: <?php echo ($thisOverdue / $highestCompare) * 100; ?>%;"></div>
                    </div>

                    <div>
                        <div class="compare-value">£<?php echo number_format((float)$lastOverdue, 2); ?></div>
                        <div class="compare-bar last-month-bar" style="height: <?php echo ($lastOverdue / $highestCompare) * 100; ?>%;"></div>
                    </div>
                </div>
                <div class="compare-label">Overdue</div>
            </div>

        </div>

        <div class="legend">
            <span style="color:#1f5f4a;">■ This Month</span>
            <span style="color:#d69e2e;">■ Last Month</span>
        </div>
    </div>

</div>

</body>
</html>