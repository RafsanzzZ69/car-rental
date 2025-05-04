<?php
include 'DBconnect.php';
?>

<h2>Book a Car</h2>
<form method="POST" action="process_booking.php">
  Customer ID: <input type="number" name="customer_id" required><br><br>
  Car Number Plate: <input type="text" name="number_plate" required><br><br>
  Pickup Location: <input type="text" name="booking_location" required><br><br>
  Current Car Location: <input type="text" name="car_location" required><br><br>
  <input type="submit" value="Book Now">
</form>
