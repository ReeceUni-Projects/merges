<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="style.css"/>

    <style>
        .main label {
            color: #ffffff !important;
        }
        .main input[type="submit"] {
            display: block;
            margin: 1px auto 0 auto; 
        }
        .main input:hover[type="submit"] {
        background-color:rgb(0, 0, 0);
        color: #ffffff;
        font-weight:500;
        }

    </style>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php");
    require_once("functions.php");

    // Handle form submission
    if (isset($_POST["addRoom"])) {
        $type_id = $_POST["type_id"];
        $floor_no = $_POST["floor_no"];
        $room_status = $_POST["room_status"];

        $result = addRoom($conn, $type_id, $floor_no, $room_status);

        if ($result === true) {
            header("Location: viewRooms.php");
            exit();
        } else {
            $error = $result;
        }
    } else {
        $error = "";
    }
    ?>

    <div>
        <h2 class="centered-header">Add New Room</h2>
    </div>

    <div class="main">
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="type_id">Type ID</label>
            <input type="text" id="type_id" name="type_id" required>

            <label for="floor_no">Floor Number</label>
            <input type="text" id="floor_no" name="floor_no">

            <label for="room_status">Room Status</label>
            <?php dropdownStatus($selected = '') ?>

            <input type="submit" name="addRoom" value="Add Room">
        </form>
    </div>
</body>
</html>
