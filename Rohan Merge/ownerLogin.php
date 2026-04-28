<?php
session_start();

$error = "";


$owner_username = "owner";
$owner_password = "LuckyNest123";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $owner_username && $password === $owner_password) {
        $_SESSION['owner_logged_in'] = true;
        $_SESSION['owner_username'] = $owner_username;

        header("Location: ownerDashboard.php");
        exit();
    } else {
        $error = "Invalid owner credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .owner-login-box {
            width: 90%;
            max-width: 420px;
            margin: 160px auto 60px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .owner-login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f2d2a;
        }

        .owner-login-box label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .owner-login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .owner-login-box button {
            width: 100%;
            padding: 12px;
            background: #1f5f4a;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .owner-login-box button:hover {
            background: #174a39;
        }

        .error-text {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="owner-login-box">
    <h2>Owner Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error-text"><?php echo ($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>