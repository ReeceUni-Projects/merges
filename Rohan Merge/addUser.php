<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php"); // Make sure $conn is available
    require_once("functions.php");

    // Handle form submission
    if (isset($_POST["addUser"])) {
        $userFname = $_POST["userFname"];
        $userLname = $_POST["userLname"];
        $userMname = $_POST["userMname"];
        $userEmail = $_POST["email"];
        $userPhoneNo = $_POST["userPhoneNo"];
        $userRole = $_POST["userRole"];
        $userAddress = $_POST["userAddress"];
        $occupation = $_POST["occupation"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $idType = $_POST["idType"];
        $idNumber = $_POST["idNumber"];

        addUser(
            $conn,
            $userFname,
            $userLname,
            $userMname,
            $userEmail,
            $userPhoneNo,
            $userRole,
            $userAddress,
            $occupation,
            $dateOfBirth,
            $idType,
            $idNumber
        );

        header("Location: viewUsers.php");
        exit();
    }
    ?>

    <div>
        <h2 class="centered-header">Add New User</h2>
    </div>

    <div class="main">
        <form method="post">

            <label for="userFname">First Name:</label>
            <input type="text" id="userFname" name="userFname" required>

            <label for="userLname">Last Name:</label>
            <input type="text" id="userLname" name="userLname" required>

            <label for="userMname">Middle Name:</label>
            <input type="text" id="userMname" name="userMname">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="userRole">Role:</label>
            <select id="userRole" name="userRole" required>
                <option value="Owner">Owner</option>
                <option value="Admin">Admin</option>
                <option value="Paying Guest">Paying Guest</option>
            </select>

            <label for="userAddress">Address:</label>
            <input type="text" id="userAddress" name="userAddress" required>

            <label for="occupation">Occupation:</label>
            <input type="text" id="occupation" name="occupation" required>

            <label for="dateOfBirth">Date of Birth:</label>
            <input type="text" id="dateOfBirth" name="dateOfBirth" required>

            <label for="idType">ID Type:</label>
            <select id="idType" name="idType" required>
                <option value="National Insurance">National Insurance</option>
                <option value="Passport">Passport</option>
            </select>

            <label for="idNumber">ID Number:</label>
            <input type="text" id="idNumber" name="idNumber" required>

            <label for="userPhoneNo">Phone Number:</label>
            <input type="tel" id="userPhoneNo" name="userPhoneNo" pattern="[0-9]{2}-[0-9]{3}-[0-9]{3}-[0-9]{3}" required>

            <input type="submit" name="addUser" value="Add User">
        </form>
    </div>
</body>
</html>