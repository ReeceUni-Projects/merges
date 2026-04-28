<?php
include("auth.php");
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

$prices = [
    "Breakfast" => 5,
    "Lunch" => 8,
    "Dinner" => 10,
    "Full Day" => 20,
    "Custom" => 15
];

if (isset($_POST['buy'])) {

    $meal = $_POST['buy'];
    $qty = 0;

    switch($meal) {
        case "Breakfast": $qty = $_POST['breakfast_qty']; break;
        case "Lunch": $qty = $_POST['lunch_qty']; break;
        case "Dinner": $qty = $_POST['dinner_qty']; break;
        case "Full Day": $qty = $_POST['fullday_qty']; break;
        case "Custom": $qty = $_POST['custom_qty']; break;
    }

    if ($qty > 0) {

        $price = $prices[$meal];
        $total = $price * $qty;
        $date = date("Y-m-d");

        $sql = "INSERT INTO meal_orders (user_id, meal_type, quantity, total_amount, order_date)
                VALUES ('$user_id', '$meal', '$qty', '$total', '$date')";
        mysqli_query($conn, $sql);

        $description = "$meal Meal Plan";
        $status = "Paid";

        $sql2 = "INSERT INTO payments (user_id, payment_date, description, amount, status)
                 VALUES ('$user_id', '$date', '$description', '$total', '$status')";
        mysqli_query($conn, $sql2);

        echo "<script>alert('$meal purchased! Total: £$total');</script>";
    } else {
        echo "<script>alert('Enter quantity first');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Meal Plans</title>
<link rel="stylesheet" href="style.css">

<style>
.container{
    width:600px;
    margin:140px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0px 0px 10px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
}

h1{text-align:center;}

.meal-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:15px 0;
}

.meal-actions{
    display:flex;
    gap:10px;
}

.meal-actions input{
    width:100px;
    padding:8px;
}

.meal-actions button{
    background:#2ecc71;
    border:none;
    padding:8px 15px;
    border-radius:10px;
    cursor:pointer;
}
</style>
</head>

<body>

<?php require 'navbar.php'; ?>

<div class="container">

<h1>Meal Plans</h1>

<form method="POST">

<h2>Basic Meal Plans</h2>

<div class="meal-row">
    <span>Breakfast (£5)</span>
    <div class="meal-actions">
        <input type="number" name="breakfast_qty" placeholder="Qty">
        <button name="buy" value="Breakfast">Buy</button>
    </div>
</div>

<div class="meal-row">
    <span>Lunch (£8)</span>
    <div class="meal-actions">
        <input type="number" name="lunch_qty" placeholder="Qty">
        <button name="buy" value="Lunch">Buy</button>
    </div>
</div>

<div class="meal-row">
    <span>Dinner (£10)</span>
    <div class="meal-actions">
        <input type="number" name="dinner_qty" placeholder="Qty">
        <button name="buy" value="Dinner">Buy</button>
    </div>
</div>

<h2>Special Meal Plans</h2>

<div class="meal-row">
    <span>Full Day (£20)</span>
    <div class="meal-actions">
        <input type="number" name="fullday_qty" placeholder="Qty">
        <button name="buy" value="Full Day">Buy</button>
    </div>
</div>

<div class="meal-row">
    <span>Custom (£15)</span>
    <div class="meal-actions">
        <input type="number" name="custom_qty" placeholder="Qty">
        <button name="buy" value="Custom">Buy</button>
    </div>
</div>

</form>

</div>

</body>
</html>
