<?php
require_once('DBconnect.php');

if (isset($_POST['payment_method']) && isset($_POST['booking_id'])) {
    $payment_type = $_POST['payment_method'];
    $booking_id = $_POST['booking_id'];

    $online = ($payment_type == "online") ? 1 : 0;
    $offline = ($payment_type == "offline") ? 1 : 0;

    $sql = "INSERT INTO payment (payment_id, offline, online, booking_id)
            VALUES (NULL, '$offline', '$online', '$booking_id')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Payment successful!'); window.location.href='homepage.php';</script>";
    } else {
        echo "<script>alert('Payment failed. Try again.'); window.location.href='payment_form.php';</script>";
    }
}
?>
