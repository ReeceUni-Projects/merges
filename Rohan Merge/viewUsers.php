<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php
    include("NavBar.php");
    include("db_connect.php");
    ?>
    <div>
        <h2 class="centered-header">S&M Hotel Management</h2>
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
            $total_query = "SELECT COUNT(*) as total FROM User";
            $total_result = $conn->query($total_query);
            $total_row = $total_result->fetch_assoc();
            $total_records = $total_row["total"];
            $total_pages = ceil($total_records / $records_per_page);

            // Fetch data
            $select_query = "SELECT * FROM User LIMIT $records_per_page OFFSET $offset";
            $result = $conn->query($select_query);

            echo "<table>";
            echo "
            <thead>
            <tr> 
            <td>user_id</td> 
            <td>user_fname</td> 
            <td>user_mname</td> 
            <td>user_lname</td>
            <td>email</td>
            <td>user_phoneno</td>
            <td>user_role</td>
            <td>address</td>
            <td>occupation</td>
            <td>date_of_birth</td>
            <td>id_type</td>
            <td>id_number</td>
            <td colspan='2'>Action</td> 
            </tr> 
            </thead>";

            while ($row = $result->fetch_assoc()) {
                echo "
                <tbody>
                <tr> 
                    <td>{$row['user_id']}</td> 
                    <td>{$row['user_fname']}</td>
                    <td>{$row['user_mname']}</td>
                    <td>{$row['user_lname']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['user_phoneno']}</td>
                    <td>{$row['user_role']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['occupation']}</td>
                    <td>{$row['date_of_birth']}</td>
                    <td>{$row['id_type']}</td>
                    <td>{$row['id_number']}</td>
                    <td><a href='updateUser.php?idUser={$row['user_id']}'><button>Update</button></a></td>
                    <td><a href='deleteUser.php?idUser={$row['user_id']}'><button>Delete</button></a></td>
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