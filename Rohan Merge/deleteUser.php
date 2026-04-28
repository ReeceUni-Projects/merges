<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php");
    require_once("functions.php");
    if (isset($_POST["deleteUser"])) {
        $userID = $_POST["userID"];

        deleteUser($conn, $userID);

        header("Location: viewUsers.php");
        exit();
    }

    if (isset($_GET["idUser"])) {
        $idUser = intval($_GET["idUser"]);
        $id_User = viewUser($conn, $idUser);

        if (!$id_User) {
            echo "<p>User not found.</p>";
            exit();
        }
    } else {
        echo "<p>No user selected.</p>";
        exit();
    }
    ?>

    <div>
        <h2 class="centered-header">
            Delete <?php echo $id_User[0]['user_fname']; ?>
            <?php echo $id_User[0]['user_lname']; ?>'s Details
        </h2>
    </div>

    <div class="main">
        <form method="post">
              <input type="hidden" name="userID"
                   value="<?php echo $id_User[0]['user_id']; ?>">

              <label for="userFname">First Name:</label>
              <input type="text" id="userFname"
                   value="<?php echo $id_User[0]['user_fname']; ?>" readonly>

              <label for="userLname">Last Name:</label>
              <input type="text" id="userLname"
                   value="<?php echo $id_User[0]['user_lname']; ?>" readonly>

              <label for="userMname">Middle Name:</label>
              <input type="text" id="userMname"
                   value="<?php echo $id_User[0]['user_mname']; ?>" readonly>

              <label for="email">Email:</label>
              <input type="email" id="email"
                   value="<?php echo $id_User[0]['email']; ?>" readonly>

              <label for="userRole">Role:</label>
              <input type="text" id="userRole"
                   value="<?php echo $id_User[0]['user_role']; ?>" readonly>

              <label for="userAddress">Address:</label>
              <input type="text" id="userAddress"
                   value="<?php echo $id_User[0]['address']; ?>" readonly>

              <label for="occupation">Occupation:</label>
              <input type="text" id="occupation"
                   value="<?php echo $id_User[0]['occupation']; ?>" readonly>

              <label for="dateOfBirth">Date of Birth:</label>
              <input type="text" id="dateOfBirth"
                   value="<?php echo $id_User[0]['date_of_birth']; ?>" readonly>

              <label for="idType">ID Type:</label>
              <input type="text" id="idType"
                   value="<?php echo $id_User[0]['id_type']; ?>" readonly>

              <label for="idNumber">ID Number:</label>
              <input type="text" id="idNumber"
                   value="<?php echo $id_User[0]['id_number']; ?>" readonly>

              <label for="userPhoneNo">Phone Number:</label>
              <input type="tel" id="userPhoneNo"
                   value="<?php echo $id_User[0]['user_phoneno']; ?>" readonly>

              <input type="submit" name="deleteUser" value="Delete User">
       </form>
</div>
</body>
</html>