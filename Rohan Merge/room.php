<?php
session_start();
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rooms & Pricing - LuckyNest</title>

<link rel="stylesheet" href="style.css">

<style>
.rooms-container{
    width:80%;
    margin:150px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    position:relative;
    z-index:1;
}

.rooms-container h1{
    text-align:center;
    margin-bottom:30px;
}

.pricing-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:40px;
}

.pricing-table th{
    background:#000;
    color:white;
    padding:12px;
    text-align:center;
}

.pricing-table td{
    padding:12px;
    text-align:center;
    background:#f8f8f8;
    border-bottom:1px solid #ddd;
}

.amenities-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:40px;
}

.amenities-table th{
    background:#000;
    color:white;
    padding:12px;
    text-align:left;
}

.amenities-table td{
    padding:12px;
    background:#f8f8f8;
    border-bottom:1px solid #ddd;
}

.section-title{
    font-size:24px;
    font-weight:bold;
    margin:30px 0 15px 0;
}

.room-desc{
    background:#f2f2f2;
    padding:20px;
    border-radius:10px;
    margin-top:20px;
}
</style>
</head>

<body>

<div class="rooms-container">

<h1>Rooms & Pricing</h1>


<div class="section-title">Room Rates</div>

<table class="pricing-table">
    <tr>
        <th></th>
        <th>Single</th>
        <th>Double</th>
        <th>Triple</th>
    </tr>
    <tr>
        <td><strong>Weekly Rate</strong></td>
        <td>£150</td>
        <td>£600</td>
        <td>£750</td>
    </tr>
    <tr>
        <td><strong>Monthly Rate</strong></td>
        <td>£100</td>
        <td>£400</td>
        <td>£500</td>
    </tr>
    <tr>
        <td><strong>Security Deposit</strong></td>
        <td>£70</td>
        <td>£280</td>
        <td>£350</td>
    </tr>
</table>

<div class="section-title">Amenities</div>

<table class="amenities-table">
    <tr>
        <th>Amenity</th>
        <th>Availability</th>
        <th>Charges</th>
    </tr>
    <tr>
        <td>WiFi</td>
        <td>All Rooms</td>
        <td>Included in rent</td>
    </tr>
    <tr>
        <td>Laundry</td>
        <td>On Request</td>
        <td>£1.90/load or £14.25/month</td>
    </tr>
    <tr>
        <td>Food</td>
        <td>Meal Plans</td>
        <td>Variable</td>
    </tr>
    <tr>
        <td>Housekeeping</td>
        <td>Weekly Basis</td>
        <td>£4.75/session or £19/month</td>
    </tr>
</table>

<div class="section-title">Additional Services</div>

<table class="amenities-table">
    <tr>
        <th>Service</th>
        <th>Availability</th>
        <th>Charges</th>
    </tr>
    <tr>
        <td>Parking</td>
        <td>Limited</td>
        <td>£28.50/month</td>
    </tr>
    <tr>
        <td>AC</td>
        <td>Select Rooms</td>
        <td>£19.50/month</td>
    </tr>
</table>

<div class="section-title">Our Rooms</div>

<div class="room-desc">
    LuckyNest offers a variety of room options designed for comfort, privacy, and convenience.  
    Whether you're looking for a cozy single room or a shared triple room, each space is equipped  
    with essential amenities, high speed WiFi, and access to all onsite services.  
    Our rooms are maintained regularly to ensure a clean and welcoming environment.
</div>

</div>

</body>
</html>
