<?php
include("ownerAuth.php");
include("db_connect.php");

$checkRooms = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms");
$row = mysqli_fetch_assoc($checkRooms);

if ($row['total'] == 0) {
    for ($floor = 1; $floor <= 50; $floor++) {
        for ($room = 1; $room <= 10; $room++) {
            $roomNumber = ($floor * 100) + $room;

            $stmt = $conn->prepare("INSERT INTO rooms (room_number, floor_number, status) VALUES (?, ?, 'Available')");
            $stmt->bind_param("si", $roomNumber, $floor);
            $stmt->execute();
            $stmt->close();
        }
    }
}

if (isset($_POST['update_status'])) {
    $room_id = $_POST['room_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE rooms SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $room_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ownerRooms.php");
    exit();
}

$totalRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms"))['total'];
$occupiedRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE status='Occupied'"))['total'];
$availableRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rooms WHERE status='Available'"))['total'];

$selectedFloor = isset($_GET['floor']) ? (int)$_GET['floor'] : 1;

$rooms = mysqli_query($conn, "SELECT * FROM rooms WHERE floor_number = $selectedFloor ORDER BY room_number ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Owner Rooms - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .rooms-container {
            width: 92%;
            max-width: 1200px;
            margin: 120px auto 50px auto;
        }

        .rooms-title {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 220px;
            background: rgba(255,255,255,0.96);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #1f2d2a;
        }

        .stat-card p {
            font-size: 30px;
            font-weight: bold;
            margin: 0;
            color: #174a39;
        }

        .filter-box {
            background: rgba(255,255,255,0.96);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }

        .filter-box select {
            width: 180px;
            padding: 10px;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
        }

        .room-card {
            background: rgba(255,255,255,0.96);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }

        .room-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .available {
            color: #1f7a4d;
            font-weight: bold;
        }

        .occupied {
            color: #b22222;
            font-weight: bold;
        }

        .room-card button {
            margin-top: 12px;
            width: 100%;
            padding: 10px;
            background: #1f5f4a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .room-card button:hover {
            background: #174a39;
        }
    </style>
</head>

<body>

<?php include("ownerNavbar.php"); ?>

<div class="rooms-container">
    <h1 class="rooms-title">Hotel Room Overview</h1>

    <div class="stats-row">
        <div class="stat-card">
            <h3>Total Rooms</h3>
            <p><?php echo $totalRooms; ?></p>
        </div>

        <div class="stat-card">
            <h3>Occupied Rooms</h3>
            <p><?php echo $occupiedRooms; ?></p>
        </div>

        <div class="stat-card">
            <h3>Available Rooms</h3>
            <p><?php echo $availableRooms; ?></p>
        </div>
    </div>

    <div class="filter-box">
        <form method="GET">
            <label><strong>Select Floor:</strong></label>
            <select name="floor" onchange="this.form.submit()">
                <?php for ($i = 1; $i <= 50; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php if ($selectedFloor == $i) echo "selected"; ?>>
                        Floor <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>
    </div>

    <div class="room-grid">
        <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
            <div class="room-card">
                <div class="room-number">Room <?php echo ($room['room_number']); ?></div>

                <?php if ($room['status'] == "Occupied"): ?>
                    <div class="occupied">Occupied</div>
                <?php else: ?>
                    <div class="available">Available</div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">

                    <?php if ($room['status'] == "Occupied"): ?>
                        <input type="hidden" name="new_status" value="Available">
                        <button type="submit" name="update_status">Mark Available</button>
                    <?php else: ?>
                        <input type="hidden" name="new_status" value="Occupied">
                        <button type="submit" name="update_status">Mark Occupied</button>
                    <?php endif; ?>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>