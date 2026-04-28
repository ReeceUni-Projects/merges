<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Delete Meal Plan</title>
</head>
<?php
    require_once("functs_temp.php");

    changeSession();

    if (isset($_POST["deleteService"]))
    {
        $rID = $_POST["id"];
        $uID = $_POST["userID"];
        $sID = $_POST["serviceID"];
        $requestDate = $_POST["reqDate"];
        $scheduleDate = $_POST["schDate"];
        $serviceStat = $_POST["serviceStatus"];
        $price = $_POST["price"];

        deleteData("SERVICE_REQUEST", [$rID, $uID, $sID, $requestDate, $scheduleDate, $serviceStat, $price]);
        header("Location: serviceSchedule.php");
    }

    if (isset($_POST["retrievedID"])) {
        $rID = $_POST["id"];
        /*
        if (!checkServiceRequestExists($rID)) {        
            header("Location: serviceSchedule.php");
        }
        */
    }

    $serviceReq = viewData("SERVICE_REQUEST", $rID);
?>
<body>
    <div class="container">

        <?php include("navbar.php"); ?>

        <div class="main">
            <div>
                <h2>Delete Service Request (<?php echo $serviceReq[0]['service_type']; ?>) , <?php echo $serviceReq[0]['request_id']; ?>?</h2>
            </div>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $serviceReq[0]['request_id']; ?>" />

                <label for="username"> Username </label>
                <input type="text" minlength="1" id="username" name="username" placeholder="Username" value="<?php echo $serviceReq[0]['user_fname'] . " " . $serviceReq[0]['user_lname']; ?>" required readonly />
                <label for="sType"> Service Type </label>
                <input type="text" minlength="1" id="sType" name="service_type" placeholder="Service Type" value="<?php echo $serviceReq[0]['service_type']; ?>" required readonly />
                

                <label for="uID"> User ID </label>
                <input type="number" minlength="1" id="uID" name="userID" placeholder="User ID" value="<?php echo $serviceReq[0]['user_id']; ?>" required readonly />
                <label for="sID"> Service ID </label>
                <input type="number" minlength="1" id="sID" name="serviceID" placeholder="Service ID" value="<?php echo $serviceReq[0]['service_id']; ?>" required readonly />
                <label for="rDate"> Request Date </label>
                <input type="date" minlength="1" id="rDate" name="reqDate" placeholder="Request Date" value="<?php echo date("Y-m-d", strtotime($serviceReq[0]['request_date'])); ?>" required readonly />
                <label for="sDate"> Schedule Date </label>
                <input type="date" minlength="1" id="sDate" name="schDate" placeholder="Schedule Date" value="<?php echo date("Y-m-d", strtotime($serviceReq[0]['schedule_date'])); ?>" required readonly />
                <label for="sStatus"> Service Status </label>
                <input type="text" minlength="1" id="sStatus" name="serviceStatus" placeholder="Service Status" value="<?php echo $serviceReq[0]['service_status']; ?>" required readonly />
                <label for="price"> Price </label>
                <input type="number" minlength="1" id="price" name="price" step="0.01" placeholder="Price" value="<?php echo $serviceReq[0]['price']; ?>" required readonly />

                <button type="submit" name="deleteService" class="formBtn" value="Delete Meal">Delete Meal</button>
            </form>
        </div>

    </div>
</body>
</html>