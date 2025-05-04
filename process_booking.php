<?php
include 'DBconnect.php';

$customer_id = $_POST['customer_id'];
$number_plate = $_POST['number_plate'];
$booking_location = $_POST['booking_location'];
$car_location = $_POST['car_location'];
$booking_time = date('Y-m-d H:i:s');

// Insert into booking table
$insertQuery = "INSERT INTO booking (customer_id, booking_time, booking_location, car_location)
                VALUES ('$customer_id', '$booking_time', '$booking_location', '$car_location')";
mysqli_query($conn, $insertQuery);

// Update car status
$updateCar = "UPDATE car SET availability = 'Booked' WHERE number_plate = '$number_plate'";
mysqli_query($conn, $updateCar);

echo "Car booked successfully.";
?>
