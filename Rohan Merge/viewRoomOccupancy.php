<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>View Room Occupancy</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        
        .centered-header { text-align:center; margin:20px 0; }
        .main { max-width:1000px; margin:0 auto; padding:20px; }
        .summary { display:flex; gap:16px; margin-bottom:18px; }
        .card { background-color:#000000; padding:12px 16px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.06); flex:1; text-align:center; }
        .card h3 { margin:0 0 6px; font-size:14px; color:#ffffff; }
        .card p { margin:0; font-size:20px; font-weight:600; color:#ffffff; }
        table { width:100%; border-collapse:collapse; margin-top:8px; }
        thead td {font-weight:700; padding:10px; background:#000000 !important; border-bottom:1px solid #ffffff; text-align:center;}
        table {background-color: #ffffff !important; box-shadow: none !important;}
        thead tr {background-color: #efefef !important; color: #ffffff !important;}
        tbody tr {background-color: #ffffff !important; border-bottom:2px solid #000000 !important;}
        tbody td {background-color: #ffffff !important; color: #000000 !important; padding:10px; border-bottom:1px solid #eee; text-align:center; }
        .percentage { color:#0b6; font-weight:700; }
        .no-data { text-align:center; padding:20px; color:#666; }
        button { cursor:pointer; }

    </style>
</head>
<body>
<?php
include("NavBar.php");
include("db_connect.php");

$overall_sql = "
    SELECT
        COUNT(*) AS total_rooms,
        SUM(CASE WHEN room_status IN ('Occupied','Active') THEN 1 ELSE 0 END) AS total_occupied,
        SUM(CASE WHEN room_status IN ('Vacant','Not Active') THEN 1 ELSE 0 END) AS total_vacant
    FROM Room
";

$overall_result = $conn->query($overall_sql);

if ($overall_result === false) {
    $overall = null;
} else {
    $overall = $overall_result->fetch_assoc();
}

$floor_sql = "
    SELECT
        floor_no,
        COUNT(*) AS total_rooms,
        SUM(CASE WHEN room_status IN ('Occupied','Active','Unavailable') THEN 1 ELSE 0 END) AS occupied,
        SUM(CASE WHEN room_status IN ('Vacant','Not Active') THEN 1 ELSE 0 END) AS vacant
    FROM Room
    GROUP BY floor_no
    ORDER BY floor_no
";
$floor_result = $conn->query($floor_sql);
if ($floor_result === false) {
    $floor_result = null;
}
$rooms_sql = "SELECT * FROM Room ORDER BY floor_no, room_id";
$rooms_result = $conn->query($rooms_sql);
if ($rooms_result === false) {
    $rooms_result = null;
}
?>
    <div>
        <h2 class="centered-header">View Room Occupancy</h2>
    </div>

    <div class="main">
        <?php if ($overall): ?>
            <div class="summary" role="region" aria-label="Overall occupancy summary">
                <div class="card">
                    <h3>Total Occupied</h3>
                    <p><?php echo $overall['total_occupied']; ?></p>
                </div>
                <div class="card">
                    <h3>Total Vacant</h3>
                    <p><?php echo $overall['total_vacant']; ?></p>
                </div>
                <div class="card">
                    <h3>Vacant Percentage</h3>
                    <?php
                        $totalRooms = $overall['total_rooms'];
                        $vacant = $overall['total_vacant'];
                        $vacPercent = $totalRooms > 0 ? ($vacant / $totalRooms) * 100 : 0;
                    ?>
                    <p class="percentage"><?php echo number_format($vacPercent, 2); ?>%</p>
                </div>
            </div>
        <?php endif; ?>
        <?php
        if ($floor_result && $floor_result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr>
                    <td>Floor Number</td>
                    <td>Total Occupied</td>
                    <td>Total Vacant</td>
                    <td>Vacant Percentage</td>
                  </tr></thead>";
            echo "<tbody>";
            while ($f = $floor_result->fetch_assoc()) {
                $floorNo = $f['floor_no'];
                $occupied = $f['occupied'];
                $vacant = $f['vacant'];
                $total = $f['total_rooms'];
                $vacPct = $total > 0 ? ($vacant / $total) * 100 : 0;
                echo "<tr>
                        <td>{$floorNo}</td>
                        <td>{$occupied}</td>
                        <td>{$vacant}</td>
                        <td class='percentage'>" . number_format($vacPct, 2) . "%</td>
                      </tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='no-data'>No room data available.</div>";
        }
        ?>
    </div>
</body>
</html>
