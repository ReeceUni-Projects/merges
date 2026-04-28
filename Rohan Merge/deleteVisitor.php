<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Visitor</title>
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

    
    if (isset($_POST["deleteVisitor"])) {
        $visitorID = $_POST["visitorID"];

        deleteVisitor($conn, $visitorID);
        header("Location: viewVisitors.php");
        exit();
    }

    
    $idVisitor = $_GET["idVisitor"];
    $id_Visitor = viewVisitor($conn, $idVisitor);
    ?>
    
    <div>
        <h2 class="centered-header">Delete  <?php echo $id_Visitor[0]['visitor_fname']; ?></h2>
    </div>

    <div class="main">
        <p class="warning">Are you sure you want to delete this visitor?</p>

        <form method="post">
            <input type="hidden" name="visitorID" value="<?php echo ($id_Visitor[0]['visitor_id']); ?>" required readonly>
            <label for="visitor_fname">First Name</label>
            <input type="text" name="visitor_fname" value="<?php echo ($id_Visitor[0]['visitor_fname']); ?>" required readonly>
            <label for="visitor_mname">Middle Name</label>
            <input type="text" name="visitor_mname" value="<?php echo ($id_Visitor[0]['visitor_mname']); ?>" readonly>
            <label for="visitor_lname">Last Name</label>
            <input type="text" name="visitor_lname" value="<?php echo ($id_Visitor[0]['visitor_lname']); ?>" required readonly>
            <label for="id_type">ID Type</label>
            <input type="text" name="id_type" value="<?php echo ($id_Visitor[0]['id_type']); ?>" required readonly>
            <label for="id_number">ID Number</label>
            <input type="text" name="id_number" value="<?php echo ($id_Visitor[0]['id_number']); ?>" required readonly>
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" name="vehicle_number" value="<?php echo ($id_Visitor[0]['vehicle_number']); ?>" required readonly>
            <input type="submit" name="deleteVisitor" value="Delete Visitor" class="delete-button">
        </form>
    </div>
</body>
</html>
