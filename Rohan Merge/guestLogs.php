<?php
include("ownerAuth.php");
include("db_connect.php");

$logs = mysqli_query($conn, "
    SELECT 
        users.id AS user_id,
        users.username,
        users.name,
        payments.payment_date,
        payments.description,
        payments.amount,
        payments.status
    FROM payments
    INNER JOIN users ON payments.user_id = users.id
    ORDER BY payments.payment_date DESC, payments.id DESC
    LIMIT 50
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Logs - LuckyNest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .logs-container {
            width: 92%;
            max-width: 1300px;
            margin: 120px auto 40px auto;
            background: rgba(255,255,255,0.97);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .logs-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<?php include("ownerNavbar.php"); ?>

<div class="logs-container">
    <h2>Guest Logs</h2>

    <table>
        <thead>
            <tr>
                <th>Guest ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Amount (£)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($logs && mysqli_num_rows($logs) > 0): ?>
                <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                    <tr>
                        <td><?php echo $log['user_id']; ?></td>
                        <td><?php echo $log['username']; ?></td>
                        <td><?php echo $log['name']; ?></td>
                        <td><?php echo $log['payment_date']; ?></td>
                        <td><?php echo $log['description']; ?></td>
                        <td>£<?php echo number_format((float)$log['amount'], 2); ?></td>
                        <td><?php echo ($log['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No guest logs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>