<?php
include('DBconnect.php');
$conn = new mysqli('localhost', 'root', '', 'car rental');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle car posting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_car'])) {
    $photo_name = 'default_car.jpg';
    if (!empty($_FILES['photo']['name'])) {
        $photo_name = uniqid() . '.jpg';
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo_name);
    }
    
    $stmt = $conn->prepare("INSERT INTO car (number_plate, model, brand, image, location, availability) VALUES (?, ?, ?, ?, ?, 'available')");
    $stmt->bind_param("sssss", $_POST['number_plate'], $_POST['model'], $_POST['brand'], $photo_name, $_POST['location']);
    $stmt->execute();
    echo "<script>alert('Car posted successfully!');</script>";
}

// Handle car booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_car'])) {
    $car_id = $_POST['car_id'];
    $conn->query("UPDATE car SET availability='booked' WHERE number_plate='$car_id'");
    echo "<script>alert('Car booked successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Rental System</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .btn { 
            padding: 10px 20px; 
            background: #4CAF50; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
            font-size: 16px;
        }
        .btn-post { background: #2196F3; }
        .cars-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 20px; 
            margin-top: 20px;
        }
        .car-card { 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 15px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .car-card img { 
            width: 100%; 
            height: 180px; 
            object-fit: cover; 
            border-radius: 5px;
        }
        .car-status { 
            padding: 5px 10px; 
            border-radius: 4px; 
            font-weight: bold; 
            display: inline-block;
            margin: 10px 0;
        }
        .available { background: #4CAF50; color: white; }
        .booked { background: #f44336; color: white; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Car Rental System</h1>
        <button class="btn btn-post" onclick="openModal('postModal')">Post Your Car</button>
    </div>

    <h2>Available Cars</h2>
    <div class="cars-grid">
        <?php
        $result = $conn->query("SELECT * FROM car");
        while ($car = $result->fetch_assoc()):
            $status_class = ($car['availability'] == 'available') ? 'available' : 'booked';
            $status_text = ($car['availability'] == 'available') ? 'Available' : 'Booked';
        ?>
            <div class="car-card">
                <img src="uploads/<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['brand']) ?>">
                <h3><?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h3>
                <p><strong>Plate:</strong> <?= htmlspecialchars($car['number_plate']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($car['location']) ?></p>
                <div class="car-status <?= $status_class ?>"><?= $status_text ?></div>
                
                <?php if ($car['availability'] == 'available'): ?>
                    <form method="post" style="margin-top: 10px;">
                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['number_plate']) ?>">
                        <button type="submit" name="book_car" class="btn">Book This Car</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Post Car Modal -->
    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('postModal')">&times;</span>
            <h2>Post Your Car</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Number Plate:</label>
                    <input type="text" name="number_plate" required>
                </div>
                <div class="form-group">
                    <label>Model:</label>
                    <input type="text" name="model" required>
                </div>
                <div class="form-group">
                    <label>Brand:</label>
                    <input type="text" name="brand" required>
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location" required>
                </div>
                <div class="form-group">
                    <label>Car Photo:</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <button type="submit" name="post_car" class="btn btn-post">Post Car</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal(id) {
            document.getElementById(id).style.display = 'block';
        }
        
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>