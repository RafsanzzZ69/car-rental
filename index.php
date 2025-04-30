<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rental - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="overlay"></div>

    <section id="header">
        <div class="site-title">RENT YOUR CAR</div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">Owners</a>
            <a href="#">Customers</a>
        </div>
    </section>

    <section id="section1">
        <div class="title">Sign In</div>
        <form action="signin.php" class="form_design" method="post">
            Username: <input type="text" name="fname" required><br/>
            Password: <input type="password" name="pass" required><br/><br/>
            <input type="submit" value="Sign In">
        </form>
    </section>

    <section id="footer">
        <p>&copy; 2025 Car Rental Project</p>
    </section>
</body>
</html>
