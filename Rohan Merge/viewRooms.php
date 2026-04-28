<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php
    include("NavBar.php");
    include("db_connect.php");
    ?>
    <div>
        <h2 class="centered-header">View Rooms</h2>
    </div>
    <div class="main">
        <?php
            $records_per_page = 5;
            $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

            if ($current_page < 1) 
            {
                $current_page = 1;
            }

            $offset = ($current_page - 1) * $records_per_page;

            // Total records
            $total_query = "SELECT COUNT(*) as total FROM Room";
            $total_result = $conn->query($total_query);
            $total_row = $total_result->fetch_assoc();
            $total_records = $total_row["total"];
            $total_pages = ceil($total_records / $records_per_page);

            // Fetch data
            $select_query = "SELECT * FROM Room LIMIT $records_per_page OFFSET $offset";
            $result = $conn->query($select_query);

            echo "<table>";
            echo "
            <thead>
            <tr> 
            <td>Room Number</td> 
            <td>Type Number</td> 
            <td>Floor Number</td> 
            <td>Room Status</td>
            <td colspan='2'>Action</td> 
            </tr> 
            </thead>";

            while ($row = $result->fetch_assoc()) {
                echo "
                <tbody>
                <tr> 
                    <td>{$row['room_id']}</td> 
                    <td>{$row['type_id']}</td>
                    <td>{$row['floor_no']}</td>
                    <td>{$row['room_status']}</td>
                    <td><a href='updateRoom.php?idRoom={$row['room_id']}'><button>Update</button></a></td>
                    <td><a href='deleteRoom.php?idRoom={$row['room_id']}'><button>Delete</button></a></td>
                </tr>
                </tbody>";
                }

            echo "</table>";

            // Pagination
            echo "<div class='pagination'>";

            if ($current_page > 1) {
                $prev_page = $current_page - 1;
                echo "<a href='?page=$prev_page'>Previous</a>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                echo "<strong>$i</strong>";
                } else {
                    echo "<a href='?page=$i'>$i</a>";
                }
            }

            if ($current_page < $total_pages) {
                $next_page = $current_page + 1;
                echo "<a href='?page=$next_page'>Next</a>";
            }

            echo "</div>";

            $conn->close();
        ?>
    </div>
</body>
</html>