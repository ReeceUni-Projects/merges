<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Update Meal Plan</title>
</head>

<?php
    require_once("functs_temp.php");

    changeSession();

    if (isset($_POST["updateService"])) {$rID = $_POST["id"];$uID = $_POST["userID"];$sID = $_POST["serviceID"];$requestDate = date("Y-m-d", strtotime($_POST["reqDate"]));$scheduleDate = date("Y-m-d", strtotime($_POST["schDate"]));$serviceStat = $_POST["serviceStatus"];$price = $_POST["price"];

        updateData("SERVICE_REQUEST", [$rID, $uID, $sID, $requestDate, $scheduleDate, $serviceStat, $price]);

        header("Location: serviceSchedule.php");
        exit();
    }

    $rID = null;
    if (isset($_POST["id"])) {
        $rID = $_POST["id"];
    }
    
    if (!$rID) {
        header("Location: serviceSchedule.php");
        exit();
    }

    $serviceReq = viewData("SERVICE_REQUEST", $rID);
    if (empty($serviceReq)) {
        header("Location: serviceSchedule.php");
        exit();
    }
?>

<body>
    <div class="container">

        <?php include("navbar.php"); ?>

        <div class="main">
            <div>
                <h2>Update Service Request (<?php echo $serviceReq[0]['service_type']; ?>) , <?php echo $serviceReq[0]['request_id']; ?>?</h2>
            </div>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $serviceReq[0]['request_id']; ?>" />

                <label for="username"> Username </label>
                <input type="text" minlength="1" id="username" name="username" placeholder="Username" value="<?php echo $serviceReq[0]['user_fname'] . " " . $serviceReq[0]['user_lname']; ?>" required readonly />
                <label for="sType"> Service Type </label>
                <input type="text" minlength="1" id="sType" name="service_type" placeholder="Service Type" value="<?php echo $serviceReq[0]['service_type']; ?>" required readonly />
                

                <label for="uID"> User ID </label>
                <input type="number" minlength="1" id="uID" name="userID" placeholder="User ID" value="<?php echo $serviceReq[0]['user_id']; ?>" required />
                <label for="sID"> Service ID </label>
                <input type="number" minlength="1" id="sID" name="serviceID" placeholder="Service ID" value="<?php echo $serviceReq[0]['service_id']; ?>" required />
                <label for="rDate"> Request Date </label>
                <input type="date" minlength="1" id="rDate" name="reqDate" placeholder="Request Date" value="<?php echo date("Y-m-d", strtotime($serviceReq[0]['request_date'])); ?>" required />
                <label for="sDate"> Schedule Date </label>
                <input type="date" minlength="1" id="sDate" name="schDate" placeholder="Schedule Date" value="<?php echo date("Y-m-d", strtotime($serviceReq[0]['schedule_date'])); ?>" required />
                <label for="sStatus"> Service Status </label>
                <input type="text" minlength="1" id="sStatus" name="serviceStatus" placeholder="Service Status" value="<?php echo $serviceReq[0]['service_status']; ?>" required />
                <label for="price"> Price </label>
                <input type="number" minlength="1" id="price" name="price" step="0.01" placeholder="Price" value="<?php echo $serviceReq[0]['price']; ?>" required />

                <button type="submit" name="updateService" class="formBtn" value="Update Meal">Update Meal</button>
            </form>
        </div>

    </div>
</body>
</html>