<?php
// 1. Connect to the Database
include('DBconnect.php');

// 2. If Rating Form is Submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
    $car_id = $_POST['car_id'];
    $rating = $_POST['rating'];

    if (!empty($car_id) && !empty($rating)) {
        // Insert into car_ratings table
        $stmt = $conn->prepare("INSERT INTO rating (id, rating_val) VALUES (?, ?)");
        $stmt->bind_param("ii", $car_id, $rating);
        $stmt->execute();
        $stmt->close();
        
        // Optional: Redirect back to homepage to avoid resubmitting form on refresh
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Rental - Available Cars</title>
    <style>
        .car-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .car-card {
            border: 1px solid #ccc;
            padding: 20px;
            width: 250px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 2px 2px 10px #aaa;
        }
        .car-card img {
            margin-top: 10px;
            border-radius: 5px;
            width: 100%;
            height: auto;
        }
        .car-card button, .car-card input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .car-card button:hover, .car-card input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .stars {
            font-size: 20px;
            color: gold;
        }
    </style>
</head>
<body>

<h1>Available Cars for Rent</h1>

<div class="car-list">
    <?php
    // 3. Fetch Available Cars
    $sql = "SELECT * FROM car WHERE availability = 'available'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $car_id = $row['car_id'];

            // 4. Fetch Average Rating
            $rating_sql = "SELECT AVG(rating) AS avg_rating FROM rating WHERE car_id = $car_id";
            $rating_result = $conn->query($rating_sql);
            $rating_row = $rating_result->fetch_assoc();
            $avg_rating = round($rating_row['avg_rating'], 1);

            echo "<div class='car-card'>";
            echo "<h2>" . htmlspecialchars($row['car_name']) . "</h2>";
            echo "<p>Model: " . htmlspecialchars($row['car_model']) . "</p>";
            echo "<p>Price per day: $" . htmlspecialchars($row['rental_price']) . "</p>";

            // 5. Show Average Rating as Stars
            echo "<p>Rating: ";
            if ($avg_rating) {
                $full_stars = floor($avg_rating);
                $half_star = ($avg_rating - $full_stars) >= 0.5 ? true : false;
                
                echo "<span class='stars'>";
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $full_stars) {
                        echo "★"; // full star
                    } elseif ($half_star && $i == $full_stars + 1) {
                        echo "☆"; // half star (optional customization)
                    } else {
                        echo "☆"; // empty star
                    }
                }
                echo "</span> ($avg_rating)";
            } else {
                echo "<span class='stars'>No ratings yet</span>";
            }
            echo "</p>";

            // 6. Show Rating Form
            ?>
            <form action="index.php" method="post">
                <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                
                <label>Rate this car:</label><br>
                <label><input type="radio" name="rating" value="1" required> ★☆☆☆☆</label><br>
                <label><input type="radio" name="rating" value="2"> ★★☆☆☆</label><br>
                <label><input type="radio" name="rating" value="3"> ★★★☆☆</label><br>
                <label><input type="radio" name="rating" value="4"> ★★★★☆</label><br>
                <label><input type="radio" name="rating" value="5"> ★★★★★</label><br>

                <input type="submit" value="Submit Rating">
            </form>
            <?php

            echo "</div>"; // car-card
        }
    } else {
        echo "<p>No cars available at the moment.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
