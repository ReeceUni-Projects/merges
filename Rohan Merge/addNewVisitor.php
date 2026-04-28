<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visitor</title>
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
        .main input[list] {
            padding: 10px;
            width: 93%;
            margin-bottom: 10px;
            border: 1px solid #ffffff;
            border-radius: 4px;
            background-color: #ffffff;
            color: #000000;
        }


    </style>
</head>
<body>
    <?php
    include("navbar.php");
    include("db_connect.php");
    require_once("functions.php");

    // Handle form submission
    if (isset($_POST["addVisitor"])) {
        $visitor_fname = $_POST["visitor_fname"];
        $visitor_mname = $_POST["visitor_mname"];
        $visitor_lname = $_POST["visitor_lname"];
        $id_type = $_POST["id_type"];
        $id_number = $_POST["id_number"];
        $vehicle_number = $_POST["vehicle_number"];


        $result = addVisitor($conn, $visitor_fname, $visitor_mname, $visitor_lname, $id_type, $id_number, $vehicle_number);

        if ($result === true) {
            header("Location: viewVisitors.php");
            exit();
        } else {
            $error = $result;
        }
    } else {
        $error = "";
    }
    ?>

    <div>
        <h2 class="centered-header">Add New Visitor</h2>
    </div>

    <div class="main">
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="visitor_fname">First Name</label>
            <input type="text" id="visitor_fname" name="visitor_fname" required>

            <label for="visitor_mname">Middle Name</label>
            <input type="text" id="visitor_mname" name="visitor_mname">

            <label for="visitor_lname">Last Name</label>
            <input type="text" id="visitor_lname" name="visitor_lname" required>

            <label for="id_type">ID Type</label>
            <?php dropdownIDtype($selected = '') ?>

            <label for="id_number">ID Number</label>
            <input type="text" id="id_number" name="id_number" required>

            <label for="vehicle_number">Vehicle Number</label>
            <input list="vehicle_nlist" id="vehicle_number" name="vehicle_number" />
            <datalist id="vehicle_nlist">
            <option value="None"></option>
            </datalist>

            <input type="submit" name="addVisitor" value="Add Visitor">
        </form>
    </div>
</body>
</html>
