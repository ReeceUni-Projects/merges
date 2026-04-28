<?php
session_start();
unset($_SESSION['owner_logged_in'], $_SESSION['owner_username']);

header("Location: ownerLogin.php");
exit();
?>