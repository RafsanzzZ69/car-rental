 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car rental";

// creating connection
$conn = new mysqli($servername, $username, $password);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    mysqli_select_db($conn, $dbname);
    echo "Connection successful";
}
?>
