<?php
include("auth.php");

$user = [
    "name" => "Test User",
    "email" => "testuser@email.com",
    "phone" => "07123 456789",
    "address" => "123 Lucky Street"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuckyNest - Profile</title>
    <link rel="stylesheet" href="style.css">

    <style>
    body{
        font-family: Arial;
    }

    .profile-container{
        width: 60%;
        margin: 140px auto 50px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2{
        text-align: center;
    }

    .details{
        margin-top: 30px;
    }

    .detail-row{
        margin-bottom: 15px;
    }

    .label{
        font-weight: bold;
    }

    .update-btn{
        display: block;
        width: 200px;
        margin: 30px auto 0 auto;
        padding: 12px;
        background: #2c3e50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
    }

    .update-btn:hover{
        background: #34495e;
    }
    </style>
</head>

<body>

<?php include("navbar.php"); ?>

<div class="profile-container">

    <h2>Account Details</h2>

    <div class="details">
        <div class="detail-row">
            <span class="label">Name:</span>
            <?php echo $user['name']; ?>
        </div>

        <div class="detail-row">
            <span class="label">Email:</span>
            <?php echo $user['email']; ?>
        </div>

        <div class="detail-row">
            <span class="label">Phone:</span>
            <?php echo $user['phone']; ?>
        </div>

        <div class="detail-row">
            <span class="label">Address:</span>
            <?php echo $user['address']; ?>
        </div>
    </div>

    <a href="updateProfile.php" class="update-btn">Update Information</a>

</div>

</body>
</html>