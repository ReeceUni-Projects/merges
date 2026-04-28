<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Visitor</title>
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

    if (isset($_POST["updateVisitor"])) {
        $visitor_id = $_POST["visitor_id"];
        $visitor_fname = $_POST["visitor_fname"];
        $visitor_mname = $_POST["visitor_mname"];
        $visitor_lname = $_POST["visitor_lname"];
        $id_type = $_POST["id_type"];
        $id_number = $_POST["id_number"];
        $vehicle_number = $_POST["vehicle_number"];

        updateVisitor($conn, $visitor_id, $visitor_fname, $visitor_mname, $visitor_lname, $id_type, $id_number, $vehicle_number);
        header("Location: viewVisitors.php");
        exit();
    }

    if (isset($_GET["idVisitor"])) {
        $idVisitor = intval($_GET["idVisitor"]);
        $id_Visitor = viewVisitor($conn, $idVisitor);
        if (!$id_Visitor) {
            echo "<p>Visitor not found.</p>";
            exit();
        }
    } else {
        echo "<p>No Visitor selected.</p>";
        exit();
    }
    ?>
    <div>
        <h2 class="centered-header">Update Visitor <?php echo ($id_Visitor[0]['visitor_id']); ?>'s Details</h2>
    </div>
    <div class="main">
        <form method="post">
            <input type="hidden" name="visitor_id" value="<?php echo ($id_Visitor[0]['visitor_id']); ?>" required>
            <label for="visitor_fname">First Name</label>
            <input type="text" name="visitor_fname" value="<?php echo ($id_Visitor[0]['visitor_fname']); ?>" required>
            <label for="visitor_mname">Middle Name</label>
            <input type="text" name="visitor_mname" value="<?php echo ($id_Visitor[0]['visitor_mname']); ?>">
            <label for="visitor_lname">Last Name</label>
            <input type="text" name="visitor_lname" value="<?php echo ($id_Visitor[0]['visitor_lname']); ?>" required>
            <label for="id_type">ID Type</label>
            <?php dropdownIDtype($id_Visitor[0]['id_type']); ?>
            <label for="id_number">ID Number</label>
            <input type="text" name="id_number" value="<?php echo ($id_Visitor[0]['id_number']); ?>" required>
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" name="vehicle_number" value="<?php echo ($id_Visitor[0]['vehicle_number']); ?>">
            <input type="submit" name="updateVisitor" value="Update Visitor">
        </form>
    </div>
</body>
</html>