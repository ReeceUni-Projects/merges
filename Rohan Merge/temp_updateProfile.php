<?php
include("auth.php");

$user = [
    "name" => "Test",
    "email" => "test@user.gmail.com",
    "phone" => "1234567",
    "address" => "123 Test Lane"
];

if (isset($_POST['update'])) {
    $user['name'] = $_POST['name'];
    $user['email'] = $_POST['email'];
    $user['phone'] = $_POST['phone'];
    $user['address'] = $_POST['address'];

    echo "<script>alert('Temporary test: changes saved visually only. No database connected yet.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .update-profile-container {
            width: 90%;
            max-width: 550px;
            margin: 140px auto 50px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .update-profile-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f2d2a;
        }

        .update-profile-container label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #222;
        }

        .update-profile-container input[type="text"],
        .update-profile-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .save-btn {
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

        .save-btn:hover {
            background: #174a39;
        }
    </style>
</head>

<body>

<?php include("navbar.php"); ?>

<div class="update-profile-container">
    <h2>Update Account Information</h2>

    <form method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>

        <button type="submit" name="update" class="save-btn">Save Changes</button>
    </form>
</div>

</body>
</html>