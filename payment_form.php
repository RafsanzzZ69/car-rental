<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rental - Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="overlay"></div>

    <section id="header">
        <div class="site-title">RENT YOUR CAR</div>
        <div class="menu">
            <a href="homepage.php">Home</a>
        </div>
    </section>

    <section id="section1">
        <div class="title">Choose Payment Method</div>
        <form action="payment_process.php" class="form_design" method="post">
            Booking ID: <input type="text" name="booking_id" required><br/>
            Payment Type:<br/>
            <input type="radio" name="payment_method" value="online" required> Online<br/>
            <input type="radio" name="payment_method" value="offline" required> Offline<br/><br/>
            <input type="submit" value="Confirm Payment">
        </form>
    </section>

    <section id="footer">
        <p>&copy; 2025 Car Rental Project</p>
    </section>
</body>
</html>
