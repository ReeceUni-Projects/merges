<?php
include("auth.php");
include("db_connect.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['startPayment'])) {
    $qty = (int)$_POST['qty'];
    $price = (float)$_POST['price'];
    $description = $_POST['description'];

    if ($qty < 1) $qty = 1;

    $total = $qty * $price;

    $_SESSION['pending_amount'] = number_format($total, 2, '.', '');
    $_SESSION['pending_description'] = $description . " (x{$qty})";
}

if (isset($_POST['pay'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = date("Y-m-d");
    $status = "Paid";

    $sql = "INSERT INTO payments (user_id, payment_date, description, amount, status)
            VALUES ('$user_id', '$date', '$description', '$amount', '$status')";

    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['pending_amount'], $_SESSION['pending_description']);
        echo "<script>alert('Payment Successful'); window.location='paymentHistory.php';</script>";
        exit;
    } else {
        echo "<script>alert('Payment Failed');</script>";
    }
}

if (isset($_POST['save_pending'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = date("Y-m-d");
    $status = "Pending";

    $sql = "INSERT INTO payments (user_id, payment_date, description, amount, status)
            VALUES ('$user_id', '$date', '$description', '$amount', '$status')";

    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['pending_amount'], $_SESSION['pending_description']);
        echo "<script>alert('Payment saved as Pending'); window.location='paymentHistory.php';</script>";
        exit;
    } else {
        echo "<script>alert('Could not save pending payment');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LuckyNest - Make Payment</title>
    <link rel="stylesheet" href="style.css">

    <style>
    body {
        font-family: Arial;
        margin: 0;
        padding: 0;
    }

    .payment-box {
        width: 400px;
        margin: 150px auto 80px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    .payment-box h2 {
        text-align: center;
    }

    .payment-box label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    .payment-box input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .pay-btn {
        width: 100%;
        padding: 12px;
        background: #1f5f4a;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .pending-btn {
        width: 100%;
        padding: 12px;
        background: #d69e2e;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .desc-text {
        font-size: 14px;
        margin-bottom: 10px;
        color: #555;
        font-style: italic;
    }
    </style>
</head>

<body>

<?php require 'navbar.php'; ?>

<div class="payment-box">
    <h2>Make Payment</h2>

    <?php if (!empty($_SESSION['pending_description'])): ?>
        <div class="desc-text">
            Paying for: <?php echo ($_SESSION['pending_description']); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Name on Card</label>
        <input type="text" name="cardName">

        <label>Card Number</label>
        <input type="text" name="cardNumber" maxlength="16">

        <label>Expiry Date</label>
        <input type="month" name="expiry">

        <label>CVV</label>
        <input type="password" name="cvv" maxlength="3">

        <label>Amount (£)</label>
        <input type="number" name="amount" step="0.01"
               value="<?php echo $_SESSION['pending_amount'] ?? ''; ?>" required>

        <input type="hidden" name="description"
               value="<?php echo $_SESSION['pending_description'] ?? 'Hotel Booking Payment'; ?>">

        <button type="submit" name="pay" class="pay-btn">Make Payment</button>
        <button type="submit" name="save_pending" class="pending-btn">Save as Pending</button>
    </form>
</div>

</body>
</html>