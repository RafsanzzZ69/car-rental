<?php
include 'DBconnect.php';
$result = mysqli_query($conn, "SELECT * FROM booking");

echo "<h2>All Bookings</h2>";
echo "<table border='1'><tr><th>ID</th><th>Customer ID</th><th>Time</th><th>Pickup</th><th>Car Location</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr><td>{$row['id']}</td><td>{$row['customer_id']}</td><td>{$row['booking_time']}</td><td>{$row['booking_location']}</td><td>{$row['car_location']}</td></tr>";
}
echo "</table>";
?>
