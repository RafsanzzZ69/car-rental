<?php
$booking_id = $_GET['booking_id'] ?? '0';
$amount = $_GET['amount'] ?? '100';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Choose Payment Method</title>
</head>
<body>
    <h2>Payment for Booking #<?php echo htmlspecialchars($booking_id); ?></h2>
    <p>Total Amount: ৳<?php echo htmlspecialchars($amount); ?></p>

    <form action="payment_process.php" method="post">
        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking_id); ?>">
        <input type="hidden" name="amount" value="<?php echo htmlspecialchars($amount); ?>">

        <label>Select Payment Method:</label><br>
        <input type="radio" name="payment_method" value="online" required> Online<br>
        <input type="radio" name="payment_method" value="offline"> Offline<br><br>

        <button type="submit">Make Payment</button>
    </form>
</body>
</html>
