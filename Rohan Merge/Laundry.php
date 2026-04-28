<?php

require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laundry Services - LuckyNest</title>

    <!-- IMPORTANT: Load global CSS -->
    <link rel="stylesheet" href="style.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f2f2f2;
            margin:0;
            padding:0;
        }

        /* FIX: Push content below navbar */
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
    <h1>Laundry Services</h1>

    <div class="section-title">Quick Plans</div>

    <!-- Wash + Fold -->
    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Wash + Fold (Per Load)</div>
        <div class="price">£1.90</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Wash + Fold (Per Load)">
        <input type="hidden" name="price" value="1.90">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <!-- Wash + Iron -->
    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Wash + Iron (Per Load)</div>
        <div class="price">£2.85</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Wash + Iron (Per Load)">
        <input type="hidden" name="price" value="2.85">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <div class="section-title">Packages</div>

    <!-- Weekly Unlimited -->
    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Weekly Unlimited</div>
        <div class="price">£14.25</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Weekly Unlimited Laundry">
        <input type="hidden" name="price" value="14.25">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>

    <!-- Monthly Unlimited -->
    <form action="makePayment.php" method="POST" class="service-box">
        <div class="service-name">Monthly Unlimited</div>
        <div class="price">£47.50</div>
        <input type="number" name="qty" min="1" required placeholder="Qty">
        <input type="hidden" name="description" value="Monthly Unlimited Laundry">
        <input type="hidden" name="price" value="47.50">
        <button type="submit" name="startPayment" class="buy-btn">Buy</button>
    </form>
</div>

</body>
</html>
