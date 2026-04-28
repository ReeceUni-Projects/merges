<?php
session_start();

$_SESSION['owner_logged_in'] = true;
$_SESSION['owner_username'] = "owner";

header("Location: ownerDashboard.php");
exit();
?>