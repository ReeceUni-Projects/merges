<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = ($_POST['name']);
    $email   = ($_POST['email']);
    $message = ($_POST['message']);

    // just show a success message
    echo "<script>alert('Thank you, $name! Your message has been sent.'); window.location='contactUs.php';</script>";
}
?>