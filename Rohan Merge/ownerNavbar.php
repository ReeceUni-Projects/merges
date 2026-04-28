<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <div class="owner-navbar">
        <a href="ownerDashboard.php">Dashboard</a>
        <a href="ownerFinanceStatus.php">Finance Status</a>
        <a href="createAdmin.php">Create Admin</a>
        <a href="viewAdmins.php">View Admins</a>
        <a href="createGuest.php">Create Guest</a>
        <a href="viewGuest.php">View Guest</a>
        <a href="guestLogs.php">Guest Logs</a>
        <a href="ownerReports.php">Reports</a>
        <a href="ownerRooms.php">Rooms</a>
        <a href="ownerLogout.php">Logout</a>
    </div>
</header>