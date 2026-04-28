<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .main label {
            color: #ffffff !important;
        }
        .main input[type="submit"] {
            display: block;
            margin: 1px auto 0 auto; 
            background-color: #28a745;
        }
        .main input:hover[type="submit"] {
        background-color: #218838;
        }
        .warning {
            display: block;
            margin: -30px 0 0 -5px;
            font-weight: 600;
        }

    </style>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php"); 
    require_once("functions.php");

    if (isset($_POST["updateRoom"])) {
        $room_id = $_POST["room_id"];
        $type_id = $_POST["type_id"];
        $floor_no = $_POST["floor_no"];
        $room_status = $_POST["room_status"];

        updateRoom($conn, $room_id, $type_id, $floor_no, $room_status);
        header("Location: viewRooms.php");
        exit();
    }

    if (isset($_GET["idRoom"])) {
        $idRoom = intval($_GET["idRoom"]);
        $id_Room = viewRoom($conn, $idRoom);
        if (!$id_Room) {
            echo "<p>Room not found.</p>";
            exit();
        }
    } else {
        echo "<p>No Room selected.</p>";
        exit();
    }
    ?>
    <div>
        <h2 class="centered-header">Update Room <?php echo ($id_Room[0]['room_id']); ?>'s Details</h2>
    </div>
    <div class="main">
        <form method="post">
            <input type="hidden" name="room_id" value="<?php echo ($id_Room[0]['room_id']); ?>" required>
            <label for="type_id">Type ID</label>
            <input type="text" name="type_id" value="<?php echo ($id_Room[0]['type_id']); ?>" required>
            <label for="floor_no">Floor Number</label>
            <input type="text" name="floor_no" value="<?php echo ($id_Room[0]['floor_no']); ?>" required>
            <label for="room_status">Room Status</label>
            <?php  dropdownStatus($id_Room[0]['room_status']); ?>
            <input type="submit" name="updateRoom" value="Update Room">
        </form>
    </div>
</body>
</html>