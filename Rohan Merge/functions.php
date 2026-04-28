<?php
require_once("db_connect.php");//calls on the database file


function addBooking($conn, $userID, $roomID, $bookingDate, $checkIn, $checkOut, $paymentCycle, $bookingStatus) {
    $sql = "INSERT INTO Booking (user_id, room_id, booking_date, check_in, check_out, payment_cycle, booking_status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssss", $userID, $roomID, $bookingDate, $checkIn, $checkOut, $paymentCycle, $bookingStatus);

    return $stmt->execute();
}


function viewBooking($conn, $booking_id) {
    $stmt = $conn->prepare("
        SELECT * FROM Booking WHERE booking_id = ?
    ");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function updateBooking($conn, $booking_id, $userID, $roomID, $bookingDate, $checkIn, $checkOut, $paymentCycle, $status) {
    $stmt = $conn->prepare("
        UPDATE Booking SET
            user_id = ?,
            room_id = ?,
            booking_date = ?,
            check_in = ?,
            check_out = ?,
            payment_cycle = ?,
            booking_status = ?
        WHERE booking_id = ?
    ");

    $stmt->bind_param(
        "iisssssi",
        $userID,
        $roomID,
        $bookingDate,
        $checkIn,
        $checkOut,
        $paymentCycle,
        $status,
        $booking_id
    );

    return $stmt->execute();
}

function deleteBooking($conn, $booking_id) {
    $stmt = $conn->prepare("DELETE FROM Booking WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    return $stmt->execute();
}

//payments 
function viewAllPayments($conn, $limit, $offset) {
    $sql = "SELECT * FROM Payment LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    return $stmt->get_result();
}

function countPayments($conn) {
    $sql = "SELECT COUNT(*) AS total FROM Payment";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function viewPayment($conn, $paymentID) {
    $sql = "SELECT * FROM Payment WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addPayment($conn, $booking_id, $amount, $payment_date, $status, $lateFee, $paymentMethod, $paymentType) {
    $sql = "INSERT INTO Payment (booking_id, amount, payment_date, payment_status, late_fee, payment_method, payment_type)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idssdss", $booking_id, $amount, $payment_date, $status, $lateFee, $paymentMethod, $paymentType);
    return $stmt->execute();
}

function updatePayment($conn, $paymentID, $booking_id, $amount, $payment_date, $status, $lateFee, $paymentMethod, $paymentType) {
    $sql = "UPDATE Payment 
            SET booking_id = ?, amount = ?, payment_date = ?, payment_status = ?, late_fee = ?, payment_method = ?, payment_type = ?
            WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idssdssi", $booking_id, $amount, $payment_date, $status, $lateFee, $paymentMethod, $paymentType, $paymentID);
    return $stmt->execute();
}

function deletePayment($conn, $paymentID) {
    $sql = "DELETE FROM Payment WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $paymentID);
    return $stmt->execute();
}

// invoices

function addInvoice($conn, $booking_id, $amount, $issue_date, $due_date, $invoice_status) {
    $sql = "INSERT INTO Invoice (booking_id, amount, issue_date, due_date, invoice_status)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsss", $booking_id, $amount, $issue_date, $due_date, $invoice_status);

    return $stmt->execute();
}

function viewInvoice($conn, $invoice_id) {
    $sql = "SELECT * FROM Invoice WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function viewAllInvoices($conn, $limit, $offset) {
    $sql = "SELECT * FROM Invoice LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    return $stmt->get_result();
}

function countInvoices($conn) {
    $sql = "SELECT COUNT(*) AS total FROM Invoice";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function updateInvoice($conn, $invoice_id, $booking_id, $amount, $issue_date, $due_date, $invoice_status) {
    $sql = "UPDATE Invoice 
            SET booking_id = ?, amount = ?, issue_date = ?, due_date = ?, invoice_status = ?
            WHERE invoice_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsssi", $booking_id, $amount, $issue_date, $due_date, $invoice_status, $invoice_id);

    return $stmt->execute();
}

function deleteInvoice($conn, $invoice_id) {
    $sql = "DELETE FROM Invoice WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoice_id);

    return $stmt->execute();
}

function addUser($conn, $userFname, $userLname, $userMname, $userEmail, $userPhoneNo, $userRole, $userAddress, $occupation, $dateOfBirth, $idType, $idNumber) {
    $stmt = $conn->prepare("
        INSERT INTO User (
            user_fname,
            user_lname,
            user_mname,
            email,
            user_phoneno,
            user_role,
            address,
            occupation,
            date_of_birth,
            id_type,
            id_number
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssssssss",
        $userFname,
        $userLname,
        $userMname,
        $userEmail,
        $userPhoneNo,
        $userRole,
        $userAddress,
        $occupation,
        $dateOfBirth,
        $idType,
        $idNumber
    );

    return $stmt->execute();
}


function viewUser($conn, $userID) {
    $stmt = $conn->prepare("SELECT * FROM User WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_detail = $result->fetch_all(MYSQLI_ASSOC); // associative array
    return $user_detail;
}



//NEW UPDATE
function updateUser($conn, $userID, $userFname, $userLname, $userMname, $userEmail, $userPhoneNo, $userRole, $userAddress, $occupation, $dateOfBirth, $idType, $idNumber) {
    $stmt = $conn->prepare("
        UPDATE User SET
            user_fname = ?,
            user_lname = ?,
            user_mname = ?,
            email = ?,
            user_phoneno = ?,
            user_role = ?,
            address = ?,
            occupation = ?,
            date_of_birth = ?,
            id_type = ?,
            id_number = ?
        WHERE user_id = ?
    ");
    $stmt->bind_param(
        "sssssssssssi",//Tells param the data types (each letter = data type. EG: s = string i = int)
        $userFname,
        $userLname,
        $userMname,
        $userEmail,
        $userPhoneNo,
        $userRole,
        $userAddress,
        $occupation,
        $dateOfBirth,
        $idType,
        $idNumber,
        $userID
    );

    if ($stmt->execute()) {
        return true;
    } else {
        return "Error: " . $stmt->error;
    }
}




function deleteUser($conn, $userID) {
    $stmt = $conn->prepare("DELETE FROM User WHERE user_id = ?");
    $stmt->bind_param("i", $userID);

    return $stmt->execute();
}


function calcServices($conn) {
    $stmt = $conn->prepare("SELECT COUNT(CASE WHEN service_id = 1 THEN 1 END) AS laundryCount, COUNT(CASE WHEN service_id = 2 THEN 1 END) AS mealPlan, COUNT(CASE WHEN service_id = 3 THEN 1 END) AS housekeeping, COUNT(CASE WHEN service_id = 4 THEN 1 END) AS upkeeping FROM servicerequest");
    $stmt->execute();
    $stmt->bind_result($laundryCount, $mealPlan, $houseKeeping, $upkeeping);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT MAX(CASE WHEN service_id = 1 THEN base_price END) AS laundryCost, MAX(CASE WHEN service_id = 2 THEN base_price END) AS mealPlanCost, MAX(CASE WHEN service_id = 3 THEN base_price END) AS housekeepingCost, MAX(CASE WHEN service_id = 4 THEN base_price END) AS upkeepingCost FROM service");
    $stmt->execute();
    $stmt->bind_result($laundryCost, $mealPlanCost, $houseKeepingCost, $upkeepingCost);
    $stmt->fetch();
    $stmt->close();   

    $laundryTotal = $laundryCount * $laundryCost;
    $mealPlanTotal = $mealPlan * $mealPlanCost;
    $houseKeepingTotal = $houseKeeping * $houseKeepingCost;
    $upkeepingTotal = $upkeeping * $upkeepingCost;
    $servicesTotal = $laundryTotal + $mealPlanTotal + $houseKeepingTotal + $upkeepingTotal;
    return [$laundryTotal, $mealPlanTotal, $houseKeepingTotal, $upkeepingTotal, $servicesTotal];
}

function calcRent($conn){
    $stmt = $conn->prepare("SELECT COALESCE(SUM(CASE WHEN invoice_status = 'Paid' THEN amount ELSE 0 END), 0) AS totalPaid, COALESCE(SUM(CASE WHEN invoice_status = 'Overdue' THEN amount ELSE 0 END), 0) AS totalOverdue, COALESCE(SUM(amount), 0) AS totalAll FROM invoice;");
    $stmt->execute();

    $stmt->bind_result($totalPaid, $totalOverdue, $totalAll);
    $stmt->fetch();

    $collectionRate = $totalPaid / $totalAll * 100;
    return [$totalPaid, $totalOverdue, $totalAll, $collectionRate];
}

function calcGuests($conn){
    $ongoingCount = 0;

    $stmt = $conn->prepare("SELECT COUNT(*) AS roomTotal FROM Room");
    $stmt->execute();

    $stmt->bind_result($totalRooms);
    $stmt->fetch();
    $stmt->close();

    $today = new DateTime();
    $today->setTime(0, 0, 0);

    $stmt = $conn->prepare("SELECT check_in, check_out FROM booking");
    $stmt->execute();

    $stmt->bind_result($checkInDate, $checkOutDate);

    while ($stmt->fetch()) {
        $checkIn = new DateTime($checkInDate);
        $checkOut = new DateTime($checkOutDate);

        $checkIn->setTime(0, 0, 0);
        $checkOut->setTime(0, 0, 0);

        if ($checkIn <= $today && $checkOut >= $today) {
            $ongoingCount++;
        }
    }
    $stmt->close();

    $occupancyRate = ($totalRooms > 0) ? ($ongoingCount / $totalRooms) * 100 : 0;

    return [$ongoingCount, $totalRooms, $occupancyRate];
}

function db_connect() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "luckynestdb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

/* User Credentials Validation */

function findUserID($email) {
    $userData = null;
    $conn = db_connect();

    $sql = "
    SELECT * 
    FROM user u
    WHERE u.email = '$email'
    ";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userID = $row['user_id'];
            $userRole = $row['user_role'];
        }
    }

    $userData = [$userID, $userRole];

    $conn->close();

    return $userData;
}

function checkUserExists($email, $pass) {
    $valid = false;
    $conn = db_connect();

    //echo "Email is: $email";

    $sql = "
    SELECT *
    FROM user u
    WHERE u.email = '$email'
    ";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["email"] == $email) {
                $valid = true;
            }
        }
    }

    $conn->close();

    return $valid;
}

function authoriseUser($email, $pass) {
    $valid = false;
    $userData = findUserID($email);

    if ($userData[0] != null) {
        session_start();
        $_SESSION["loggedIn"] = true;
        $_SESSION["userID"] = $userData[0];
        $_SESSION["userRole"] = $userData[1];
        $valid = true;
    }

    return $valid;
}

function logoutUser() {
    unset($_SESSION['loggedIn']);
    unset($_SESSION['userID']);
    session_unset();
    session_destroy();
    session_write_close();
}

function changeSession() {
    session_start();

    if (isset($_SESSION) == true) {
        if (isset($_SESSION["loggedIn"])) {
            //echo " /session {user logged in} ";
        } else {
            //echo " /session {NOT empty - user NOT logged in} ";
            logoutUser();
            header("Location: login.php");
        }
        //echo " /session {NOT empty} ";
    } else {
        logoutUser();
        header("Location: login.php");
    }
}

/* Report */


/* Payments */
function showPaymentHistory() {
    $conn = db_connect();

    $records_per_page = 5;
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    if ($current_page < 1) 
    {
        $current_page = 1;
    }

    $offset = ($current_page - 1) * $records_per_page;

    $total_query = "
    SELECT *, COUNT(*) AS total FROM payment p 
    INNER JOIN booking b ON (b.booking_id = p.booking_id)
    INNER JOIN user u ON (u.user_id = b.user_id)
    WHERE u.user_id = {$_SESSION['userID']}
    ORDER BY p.payment_ID DESC;";

    // Total records
    $total_query = "SELECT COUNT(*) as total FROM servicerequest";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row["total"];
    $total_pages = ceil($total_records / $records_per_page);

    $select_query = "
    SELECT * FROM payment p 
    INNER JOIN booking b ON (b.booking_id = p.booking_id)
    INNER JOIN user u ON (u.user_id = b.user_id)
    WHERE u.user_id = {$_SESSION['userID']}
    ORDER BY p.payment_ID DESC
    LIMIT $records_per_page OFFSET $offset;";
    $result = $conn->query($select_query);

    if ($result) {
        echo "<table>";
        echo "
        <thead>
            <tr>
                <td> Payment Date </td> 
                <td> Amount </td> 
                <td> Late Fee? </td> 
                <td> Payment Method </td> 
                <td> Payment Type </td>
            </tr>
        </thead>";

        while ($row = $result->fetch_assoc()) {
        echo "
        <tbody>
        <tr> 
            <td>{$row['payment_date']}</td> 
            <td>{$row['amount']}</td>
            <td>{$row['late_fee']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['payment_type']}</td>
        </tr>
        </tbody>";
        }
        echo "</table>";
    } else {
        echo "";
    }

    $conn->close();

}

function makePayment() {
    $conn = db_connect();





    $conn->close();

}

/* --- */


/* Food */

function showMealPlanDistr() {
    $conn = db_connect();

    $data = [];

    $sql = "
    SELECT *, COUNT(*) AS 
    FROM servicerequest
    ";

    // Total Revenue/Cost

    $sql_totalRevenue = "
    SELECT *, SUM(sr.price) AS totalPrice
    FROM servicerequest sr;
    ";

    $result = $conn->query($sql_totalRevenue);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $row['totalPrice'];
            $data[] = $row['totalPrice'];
        }
    } else {
        echo "error";
    }

    // Distribrution

    $sql_totalGuestRequests = "
    SELECT *, COUNT(sr.request_id) AS totalGuestRequests
    FROM servicerequest sr;
    ";

    $result = $conn->query($sql_totalGuestRequests);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $row['totalGuestRequests'];
            $data[] = $row['totalGuestRequests'];
        }
    } else {
        echo "error";
    }

    // Revenue

    $sql_requestCompleteRevenue = "
    SELECT *, SUM(sr.price) AS totalRevenue
    FROM servicerequest sr
    WHERE sr.service_status = 'Complete';
    ";

    $result = $conn->query($sql_requestCompleteRevenue);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $row['totalRevenue'];
            $data[] = $row['totalRevenue'];
        }
    } else {
        echo "error";
    }

    // Cost 

    $sql_requestIncompleteCost = "
    SELECT *, SUM(sr.price) AS totalCost
    FROM servicerequest sr
    WHERE sr.service_status = 'Complete';
    ";

    $result = $conn->query($sql_requestIncompleteCost);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $row['totalCost'];
            $data[] = $row['totalCost'];
        }
    } else {
        echo "error";
    }

    // 

    echo "<table>";
        echo "
        <thead>
            <tr>
            <td> </td> 
            <td> </td> 
            <td> </td> 
            <td> </td> 
            </tr> 
        </thead>";

    echo "
        <tbody>
            <tr>
                <td> Total Revenue/Cost:  &pound; {$data[0]} </td>
                <td> Total Guest Requests: &pound; {$data[1]} </td>
                <td> Total Revenue: &pound; {$data[2]} </td>
                <td> Total Cost: &pound; {$data[3]} </td>
            </tr>
        </tbody>
        ";

    $conn->close();

}


function showFoodReport() {
    $conn = db_connect();

    echo " <h1> Total Stats </h1> ";

    echo "<h2> Meal Plan Distribrution </h2>";


    // echo "<h2> Most popular Meals </h2>";    // Unable to calculate - db only has 1 meal plan currently


    //echo "<h2> Food Wastage </h2>";   // Unable to calculate due to database - not showing any wastage


    echo "<h2> Statistics </h2>";

    showMealPlanDistr();


    $conn->close();

}


/* CRUD */

/* Create */

function createEntry($table, $data) {
    $conn = db_connect();

    if ($table == "SERVICE_REQUEST") {
        $sql = "
        INSERT INTO servicerequest (user_id, service_id, request_date, schedule_date, service_status, price)
        VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iisssd", $user_id, $service_id, $request_date, $schedule_date, $service_status, $price);

            $user_id = $_SESSION["userID"];
            $service_id = 2;
            $request_date = $data[3];
            $schedule_date = date("d-m-Y", strtotime($data[3]) + 604800);
            $service_status = 'Incomplete';
            $price = $data[1];
            $stmt->execute();

            //echo "<br> Insert Success: New records created successfully <br>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }

    if ($table = "PAYMENT") {
        $sql = "
        INSERT INTO payment (booking_id, amount, payment_date, payment_status, late_fee, payment_method, payment_type)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("idssdss", $booking_id, $amount, $payment_date, $payment_status, $late_fee, $payment_method, $payment_type);

            $booking_id = 1; // Placeholder - Get booking id by using $_SESSION['userID']
            $amount = $data[0];
            $payment_date = $data[1];
            $payment_status = "Pending";
            $late_fee = 0.00; // Placeholder - No method to get late fee associated with booking?
            $payment_method = "Credit Card";
            $payment_type = "Visa";
            $stmt->execute();
            
            //echo "<br> Insert Success: New records created successfully <br>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}


function updateData($table, $data) {
    $conn = db_connect();

    //var_dump($data);

    echo $data[0];

    if ($table == "SERVICE_REQUEST") {
        $sql = "
        UPDATE servicerequest
        SET 
        user_id = ?, 
        service_id = ?,
        request_date = ?,
        schedule_date = ?,
        service_status = ?,
        price = ?
        WHERE request_id = ?
        ";

        if ($stmt = $conn->prepare($sql)) { 
            $rID = $data[0];    
            $uID = $data[1];
            $sID = $data[2];
            $reqDate = $data[3];
            $schDate = $data[4];
            $servStat = $data[5];
            $price = $data[6];

            $stmt->bind_param(
                "iisssdi",
                $uID,
                $sID,
                $reqDate,
                $schDate,
                $servStat,
                $price,
                $rID
            );

            $stmt->execute();

            //echo "<br> Update Success: New records updated successfully <br>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}

function deleteData($table, $data) {
    $conn = db_connect();

    if ($table == "SERVICE_REQUEST") {
        $sql = "
        DELETE 
        FROM servicerequest 
        WHERE request_id = ?
        ";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            $id = $data[0];

            $stmt->execute();
            //echo "<br> Delete Success: Records deleted successfully <br>";
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    $stmt->close();

    $conn->close();
}

function viewData($table, $id) {
    $conn = db_connect();
    $data_details = [];

    if ($table == "SERVICE_REQUEST") {
        $sql = "
        SELECT * 
        FROM servicerequest sr
        INNER JOIN service s ON (sr.service_id = s.service_id) 
        INNER JOIN user u ON (sr.user_id = u.user_id) 
        WHERE sr.request_id = '$id'
        ORDER BY sr.request_id DESC";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data_details[] = $row;
        }
    }

    $conn->close();
    return $data_details;
}


?>