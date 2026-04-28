<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['owner_logged_in']) || $_SESSION['owner_logged_in'] !== true) {
    header("Location: ownerLogin.php");
    exit();
}
?>