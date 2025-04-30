<?php
// Simulating a database insert without real DB connection
$booking_id = $_POST['booking_id'] ?? '0';
$amount = $_POST['amount'] ?? '0';
$method = $_POST['payment_method'] ?? 'offline';

// Fake generated ID
$payment_id = rand(1000, 9999);

// Set method flags
$online = ($method === 'online') ? 1 : 0;
$offline = ($method === 'offline') ? 1 : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Result</title>
</head>
<body>
    <h2>Payment Recorded Successfully!</h2>
    <p>Payment ID: <?php echo $payment_id; ?></p>
    <p>Booking ID: <?php echo htmlspecialchars($booking_id); ?></p>
    <p>Payment Method: <?php echo htmlspecialchars(ucfirst($method)); ?></p>
    <p>Amount Paid: ৳<?php echo htmlspecialchars($amount); ?></p>

    <h3>Stored Attributes (for your database):</h3>
    <ul>
        <li>payment_id: <?php echo $payment_id; ?></li>
        <li>offline: <?php echo $offline; ?></li>
        <li>online: <?php echo $online; ?></li>
        <li>booking_id: <?php echo htmlspecialchars($booking_id); ?></li>
    </ul>
</body>
</html>
