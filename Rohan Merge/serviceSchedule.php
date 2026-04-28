<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Service Schedule</title>
    <link rel="stylesheet" href="style.css" />
</head>
<?php

?>
<body>

    <?php

    include("db_connect.php");
    require_once("functs_temp.php");

    changeSession();

    include("navbar.php");

    ?>

    <h2 style="text-align:center;"> Admin Service Schedule </h2>
    <?php
    $conn = db_connect();

    $records_per_page = 5;
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($current_page < 1) 
    {
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $records_per_page;

    // Total records
    $total_query = "SELECT COUNT(*) as total FROM servicerequest";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row["total"];
    $total_pages = ceil($total_records / $records_per_page);

    // Fetch data
    $select_query = "
    SELECT *, u.user_id, CONCAT(u.user_fname, ' ', IFNULL(u.user_mname, ''), ' ', u.user_lname) AS 'user_name'
    FROM servicerequest sr
    INNER JOIN service s ON (sr.service_id = s.service_id) 
    INNER JOIN user u ON (sr.user_id = u.user_id)
    ORDER BY sr.request_id DESC
    LIMIT $records_per_page OFFSET $offset";
    $result = $conn->query($select_query);

    echo "<table>";
    echo "
    <thead>
    <tr>
    <td> ID </td> 
    <td> Service </td> 
    <td> Status </td> 
    <td> Request Date </td> 
    <td> Schedule Date </td>
    <td> Price </td>
    <td> Guest ID </td>
    <td> Guest Name </td>
    <td colspan='2'>Action</td> 
    </tr> 
    </thead>";

    while ($row = $result->fetch_assoc()) {
        $id = $row['request_id'];
        echo "
        <tbody>
        <tr> 
            <td>{$row['request_id']}</td> 
            <td>{$row['service_name']}</td>
            <td>{$row['service_status']}</td>
            <td>{$row['request_date']}</td>
            <td>{$row['schedule_date']}</td>
            <td>{$row['price']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['user_name']}</td>
            <form method='post' action='updateService.php' id='UPDATE#mealID#$id' style='visibility: hidden;'>
                <input type='hidden' name='id' value='$id' />
            </form>
            <form method='post' action='deleteService.php' id='DELETE#mealID#$id' style='visibility: hidden;'>
                <input type='hidden' name='id' value='$id' />
            </form>
            <td><button type='submit' name='retrievedID' form='UPDATE#mealID#$id' class='actionBtn'>Update</button></td>
            <td><button type='submit' name='retrievedID' form='DELETE#mealID#$id' class='actionBtn'>Delete</button></td>
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
    
</body>
</html>