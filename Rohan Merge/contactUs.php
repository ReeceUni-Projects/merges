<?php
session_start();
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us - LuckyNest</title>

<link rel="stylesheet" href="style.css">

<style>
.contact-container{
    width:70%;
    margin:150px auto;
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0 0 12px rgba(0,0,0,0.1);
    position:relative;
    z-index:1;
}

.contact-container h1{
    text-align:center;
    margin-bottom:30px;
}


.decor-top{
    width:100%;
    height:80px;
    background:black;
    clip-path:polygon(0 0, 100% 0, 50% 100%);
    margin-bottom:20px;
}

.decor-border{
    border:3px solid black;
    padding:25px;
    border-radius:12px;
}


.contact-info{
    font-size:18px;
    line-height:1.7;
    margin-bottom:30px;
}


.contact-form label{
    font-weight:bold;
    margin-top:10px;
    display:block;
}

.contact-form input,
.contact-form textarea{
    width:100%;
    padding:12px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:16px;
}

.contact-form button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:18px;
}

.contact-form button:hover{
    background:#27ae60;
}
</style>
</head>

<body>

<div class="contact-container">

<div class="decor-top"></div>

<div class="decor-border">

<h1>Contact Us</h1>

<div class="contact-info">
    <strong>Email:</strong> support@luckynest.com<br>
    <strong>Telephone:</strong> +44 1234 123456<br>
    <strong>Address:</strong><br>
    LuckyNest Housing<br>
    67 Luckynest Lane<br>
    Sheffield, S1 5QR<br>
</div>

<hr style="margin:30px 0;">

<h2>Send Us a Message</h2>

<form class="contact-form" method="POST" action="sendMessage.php">
    <label>Your Name</label>
    <input type="text" name="name" required>

    <label>Your Email</label>
    <input type="email" name="email" required>

    <label>Your Message</label>
    <textarea name="message" rows="5" required></textarea>

    <button type="submit">Send Message</button>
</form>

</div>
</div>

</body>
</html>
