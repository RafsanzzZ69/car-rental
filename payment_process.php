<?php
require_once('DBconnect.php');

session_start();

// Simulated login username, ideally use $_SESSION['user']
$username = 'demo_user'; // Replace with $_SESSION['user'] in live login

if (isset($_POST['payment_method']) && isset($_POST['booking_id'])) {
    $payment_type = $_POST['payment_method'];
    $booking_id = $_POST['booking_id'];

    $online = ($payment_type == "online") ? 1 : 0;
    $offline = ($payment_type == "offline") ? 1 : 0;

    // Fetch user's usage count
    $user_q = "SELECT usage_count FROM users WHERE username = '$username'";
    $user_res = mysqli_query($conn, $user_q);
    $row = mysqli_fetch_assoc($user_res);
    $usage_count = $row['usage_count'];

    // Base fare (you can also calculate based on duration/distance etc.)
    $base_fare = 1000; // Example base price

    // Apply discount based on usage count
    if ($usage_count >= 5 && $usage_count < 10) {
        $discount = 0.10; // 10%
    } elseif ($usage_count >= 10) {
        $discount = 0.20; // 20%
    } else {
        $discount = 0.00; // No discount
    }

    $final_fare = $base_fare - ($base_fare * $discount);

    // Insert payment info
    $sql = "INSERT INTO payment (payment_id, offline, online, booking_id, fare)
            VALUES (NULL, '$offline', '$online', '$booking_id', '$final_fare')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Update usage count
        $update_user = "UPDATE users SET usage_count = usage_count + 1 WHERE username = '$username'";
        mysqli_query($conn, $update_user);

        echo "<script>alert('Payment successful! Final fare after discount: $final_fare'); window.location.href='homepage.php';</script>";
    } else {
        echo "<script>alert('Payment failed. Try again.'); window.location.href='payment_form.php';</script>";
    }
}
?>
