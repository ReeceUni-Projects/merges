<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
include("navbar.php");
include("db_connect.php");
require_once("functions.php");

$serviceStats = calcServices($conn);
$rentStats = calcRent($conn);
$calcGuests = calcGuests($conn);

$totalPaid = $rentStats[0];
$totalOverdue = $rentStats[1];
$totalRent = $rentStats[2];
$collectionRate = $rentStats[3];

$totalServices = $serviceStats[4];
$laundryTotal = $serviceStats[0];
$mealPlanTotal = $serviceStats[1];
$houseKeepingTotal = $serviceStats[2];
$upkeepingTotal = $serviceStats[3];

$ongoingCount = $calcGuests[0];
$totalRooms = $calcGuests[1];
$occupancyRate = $calcGuests[2];


$total = $totalServices + $totalRent;
?>

    <div class="big-dashboard-box">
        <div class="<?php echo ($totalPaid > 5000) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Total Rent Revenue</h3>
            <div class="big-dash-stat"><?php echo "£" . number_format($totalPaid, 2); ?></div>
        </div>

        <div class="<?php echo ($totalServices > 500) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Total Services Revenue</h3>
            <div class="big-dash-stat"><?php echo "£" . number_format($totalServices, 2); ?></div>
        </div>

        <div class="<?php echo ($collectionRate > 80) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Collection Rate</h3>
            <div class="big-dash-stat"><?php echo number_format($collectionRate, 2) . "%"; ?></div>
        </div>

        <div class="<?php echo ($occupancyRate > 50 ) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Occupancy Rate</h3>
            <div class="big-dash-stat"><?php echo number_format($occupancyRate,2) . "%"; ?></div>
        </div>

        <div class="<?php echo ($ongoingCount > $totalRooms/2) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Active Guests</h3>
            <div class="big-dash-stat"><?php echo $ongoingCount; ?></div>
        </div>

        <div class="<?php echo ($total > 5500) ? 'good-big-dashboard' : 'bad-big-dashboard'; ?>">
            <h3>Total Revenue</h3>
            <div class="big-dash-stat"><?php echo "£" . number_format($total, 2); ?></div>
        </div>
    </div>

    <div class="small-dashboard-box">
        <div class="small-dashboard">
            <h4>Laundry Revenue</h4>
            <div class="small-dash-stat"><?php echo "£" . number_format($laundryTotal, 2); ?></div>
        </div>

        <div class="small-dashboard">
            <h4>Meal Plan Revenue</h4>
            <div class="small-dash-stat"><?php echo "£" . number_format($mealPlanTotal, 2); ?></div>
        </div>

        <div class="small-dashboard">
            <h4>Housekeeping Revenue</h4>
            <div class="small-dash-stat"><?php echo "£" . number_format($houseKeepingTotal, 2); ?></div>
        </div>

        <div class="small-dashboard">
            <h4>Maintenance Revenue</h4>
            <div class="small-dash-stat"><?php echo "£" . number_format($upkeepingTotal, 2); ?></div>
        </div>

        <div class="<?php echo ($totalOverdue > 3000) ? 'good-small-dashboard' : 'bad-small-dashboard'; ?>">
            <h4>Overdue payments</h4>
            <div class="small-dash-stat"><?php echo "£" . number_format($totalOverdue, 2); ?></div>
        </div>
    </div>
</body>
</html>