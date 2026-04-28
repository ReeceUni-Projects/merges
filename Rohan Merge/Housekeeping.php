<?php
include "auth.php";
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Housekeeping Services - LuckyNest</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:0;
            padding:0;
        }

        .container{
            width:80%;
            margin:140px auto 40px auto;
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        h1{
            text-align:center;
            margin-bottom:30px;
        }

        .section-title{
            font-size:22px;
            margin-top:30px;
            margin-bottom:10px;
            font-weight:bold;
        }

        .service-box{
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:#e9e9e9;
            padding:15px;
            margin-bottom:15px;
            border-radius:8px;
        }

        .service-name{
            font-size:18px;
            font-weight:bold;
        }

        .price{
            font-size:18px;
            color:#333;
        }

        input[type="number"]{
            width:70px;
            padding:5px;
            font-size:16px;
        }

        .buy-btn{
            background:#28a745;
            color:white;
            padding:10px 18px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
        }

        .buy-btn:hover{
            background:#218838;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Housekeeping</h1>

    <div class="section-title">Quick Plans</div>

    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Basic Cleaning (one session)</div>
        <div class="price">£4.75</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Basic Cleaning (one session)">
        <input type="hidden" name="price" value="4.75">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Deep Cleaning (one session)</div>
        <div class="price">£9.50</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Deep Cleaning (one session)">
        <input type="hidden" name="price" value="9.50">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <div class="section-title">Packages</div>

    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Weekly Package</div>
        <div class="price">£19.00</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Weekly Housekeeping Package">
        <input type="hidden" name="price" value="19.00">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Monthly Package</div>
        <div class="price">£66.50</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Monthly Housekeeping Package">
        <input type="hidden" name="price" value="66.50">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

</div>

</body>
</html>