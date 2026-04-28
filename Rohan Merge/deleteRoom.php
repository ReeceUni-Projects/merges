<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Room</title>
    <link rel="stylesheet" href="style.css"/>
    <style>
        .main label {
            color: #ffffff !important;
        }
        .main input[type="submit"] {
            display: block;
            margin: 1px auto 0 auto; 
            background-color: #d62424;
        }
        .main input:hover[type="submit"] {
        background-color:rgb(136, 33, 33);
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
    require_once("functions.php");

    
    if (isset($_POST["deleteRoom"])) {
        $roomID = $_POST["roomID"];

        deleteRoom($conn, $roomID);
        header("Location: viewRooms.php");
        exit();
    }

    
    $idRoom = $_GET["idRoom"];
    $id_Room = viewRoom($conn, $idRoom);
    ?>
    
    <div>
        <h2 class="centered-header">Delete Room ID: <?php echo $id_Room[0]['room_id']; ?></h2>
    </div>

    <div class="main">
        <p class="warning">Are you sure you want to delete this room?</p>

        <form method="post">
            <input type="hidden" name="roomID" value="<?php echo $id_Room[0]['room_id']; ?>" required>
            <label for="type_id">Type ID</label>
            <input type="text" name="type_id" value="<?php echo ($id_Room[0]['type_id']); ?>" required readonly>
            <label for="floor_no">Floor Number</label>
            <input type="text" name="floor_no" value="<?php echo ($id_Room[0]['floor_no']); ?>" required readonly>
            <label for="room_status">Room Status</label>
            <input type="text" name="room_status" value="<?php echo ($id_Room[0]['room_status']); ?>" required readonly>
            <input type="submit" name="deleteRoom" value="Delete Room" class="delete-button">
        </form>
    </div>
</body>
</html>
