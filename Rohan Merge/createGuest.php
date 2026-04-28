<?php
include("ownerAuth.php");
include("db_connect.php");

$message = "";

if (isset($_POST['create_guest'])) {
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Please fill in all required fields.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username or email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, name, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $name, $email, $phone, $address, $hashed_password);

            if ($stmt->execute()) {
                $message = "Guest account created successfully.";
            } else {
                $message = "Could not create guest account.";
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
    <title>Create Guest - LuckyNest</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .guest-form-box {
            width: 90%;
            max-width: 550px;
            margin: 120px auto 40px auto;
            background: rgba(255,255,255,0.96);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .guest-form-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .guest-form-box label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .guest-form-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .guest-form-box button {
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

        .guest-form-box button:hover {
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

<div class="guest-form-box">
    <h2>Create Guest</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo ($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone">

        <label>Address</label>
        <input type="text" name="address">

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="create_guest">Create Guest</button>
    </form>
</div>

</body>
</html>