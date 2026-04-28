<?php
include("ownerAuth.php");
include("db_connect.php");

$message = "";

if (isset($_POST['create_admin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $message = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Admin username already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $message = "Admin created successfully.";
            } else {
                $message = "Something went wrong.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .admin-form-box {
            width: 90%;
            max-width: 500px;
            margin: 120px auto 40px auto;
            background: rgba(255,255,255,0.96);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .admin-form-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .admin-form-box label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .admin-form-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .admin-form-box button {
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

        .admin-form-box button:hover {
            background: #174a39;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: #174a39;
        }
    </style>
</head>
<body>

<?php include("ownerNavbar.php"); ?>

<div class="admin-form-box">
    <h2>Create Admin</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo ($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Admin Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="create_admin">Create Admin</button>
    </form>
</div>

</body>
</html>