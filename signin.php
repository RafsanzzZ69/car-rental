<?php
require_once('DBconnect.php');

if (isset($_POST['fname']) && isset($_POST['pass'])) {
    $u = $_POST['fname'];
    $p = $_POST['pass'];
    
    $sql = "SELECT * FROM users WHERE username = '$u' AND password = '$p'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header("Location: homepage.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password');window.location.href='index.php';</script>";
    }
}
?>
