<?php
include("ownerAuth.php");
include("db_connect.php");

$admins = mysqli_query($conn, "SELECT id, username, created_at FROM admins ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admins - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .admins-container {
            width: 90%;
            max-width: 1100px;
            margin: 120px auto 40px auto;
            background: rgba(255,255,255,0.97);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .admins-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<?php include("ownerNavbar.php"); ?>

<div class="admins-container">
    <h2>View Admins</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($admins && mysqli_num_rows($admins) > 0): ?>
                <?php while ($admin = mysqli_fetch_assoc($admins)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['id']); ?></td>
                        <td><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No admins found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>