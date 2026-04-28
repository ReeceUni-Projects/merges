<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php"); // Make sure $conn is available
    require_once("functions.php");

    // Handle form submission
    if (isset($_POST["updateUser"])) {
        $userID = $_POST["userID"];
        $userFname = $_POST["userFname"];
        $userLname = $_POST["userLname"];
        $userMname = $_POST["userMname"];
        $email = $_POST["email"];
        $userPhoneNo = $_POST["userPhoneNo"];
        $userRole= $_POST["userRole"];
        $userAddress = $_POST["userAddress"];
        $occupation = $_POST["occupation"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $idType = $_POST["idType"];
        $idNumber = $_POST["idNumber"];

        updateUser($conn, $userID, $userFname, $userLname, $userMname, $email, $userPhoneNo,$userRole,$userAddress,$occupation,$dateOfBirth,$idType,$idNumber);
        header("Location: viewUsers.php");
        exit();
    }

    // Get User details
    if (isset($_GET["idUser"])) {
        $idUser = intval($_GET["idUser"]);
        $id_User = viewUser($conn, $idUser);
        if (!$id_User) {
            echo "<p>User not found.</p>";
            exit();
        }
    } else {
        echo "<p>No User selected.</p>";
        exit();
    }
    ?>
    <div>
        <h2 class="centered-header">Update <?php echo ($id_User[0]['user_fname']); ?> <?php echo ($id_User[0]['user_lname']); ?>'s Details</h2>
    </div>
    <div class="main">
        <form method="post">
            <input type="hidden" name="userID" value="<?php echo ($id_User[0]['user_id']); ?>">

            <label for="userFname">First Name:</label>
            <input type="text" id="userFname" name="userFname"
                value="<?php echo ($id_User[0]['user_fname']); ?>" required>

            <label for="userLname">Last Name:</label>
            <input type="text" id="userLname" name="userLname"
                value="<?php echo ($id_User[0]['user_lname']); ?>" required>

            <label for="userMname">Middle Name:</label>
            <input type="text" id="userMname" name="userMname"
                value="<?php echo ($id_User[0]['user_mname']); ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                value="<?php echo ($id_User[0]['email']); ?>" required>

            <label for="userRole">Role:</label>
            <select id="userRole" name="userRole" required>
                <option value="Owner" <?php if ($id_User[0]['user_role'] == "Owner") echo "selected"; ?>>Owner</option>
                <option value="Admin" <?php if ($id_User[0]['user_role'] == "Admin") echo "selected"; ?>>Admin</option>
                <option value="Paying Guest" <?php if ($id_User[0]['user_role'] == "Paying Guest") echo "selected"; ?>>Paying Guest</option>
            </select>

            <label for="userAddress">Address:</label>
            <input type="text" id="userAddress" name="userAddress"
                value="<?php echo ($id_User[0]['address']); ?>" required>

            <label for="occupation">Occupation:</label>
            <input type="text" id="occupation" name="occupation"
                value="<?php echo ($id_User[0]['occupation']); ?>" required>

            <label for="dateOfBirth">Date of Birth:</label>
            <input type="text" id="dateOfBirth" name="dateOfBirth"
                value="<?php echo ($id_User[0]['date_of_birth']); ?>" required>

            <label for="idType">ID Type:</label>
            <select id="idType" name="idType" required>
                <option value="National Insurance" <?php if ($id_User[0]['id_type'] == "National Insurance") echo "selected"; ?>>National Insurance</option>
                <option value="Passport" <?php if ($id_User[0]['id_type'] == "Passport") echo "selected"; ?>>Passport</option>
            </select>

            <label for="idNumber">ID Number:</label>
            <input type="text" id="idNumber" name="idNumber"
                value="<?php echo ($id_User[0]['id_number']); ?>" required>

            <label for="userPhoneNo">Phone Number:</label>
            <input type="tel"
                id="userPhoneNo"
                name="userPhoneNo"
                pattern="[0-9]{2}-[0-9]{3}-[0-9]{3}-[0-9]{3}"
                value="<?php echo ($id_User[0]['user_phoneno']); ?>" required>

            <input type="submit" name="updateUser" value="Update User">
        </form>
    </div>
</body>
</html>