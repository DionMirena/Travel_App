<?php
require 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$hotel = null;
$error_message = '';
$success_message = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: admin_hotels.php');
    exit();
}

$hotel_id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
    $stmt->execute([$hotel_id]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$hotel) {
        $error_message = "Hotel not found!";
    }
} catch (PDOException $e) {
    $error_message = "Error fetching hotel: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    $location = $_POST['location'] ?? '';
    $amenities = $_POST['amenities'] ?? '';
    $rating = $_POST['rating'] ?? '';
    
    if (empty($name) || empty($description) || empty($price) || empty($location)) {
        $error_message = "Please fill in all required fields!";
    } else {
        try {

            $stmt = $pdo->prepare("
                UPDATE hotels 
                SET name = ?, description = ?, price = ?, location = ?, amenities = ?, rating = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            
            $stmt->execute([$name, $description, $price, $location, $amenities, $rating, $hotel_id]);
            
            $success_message = "Hotel updated successfully!";
            
            $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
            $stmt->execute([$hotel_id]);
            $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $error_message = "Error updating hotel: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hotel - Travel App</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .edit-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group textarea {
            height: 120px;
            resize: vertical;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-back {
            background: #6c757d;
        }
        .btn-back:hover {
            background: #545b62;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="edit-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Edit Hotel</h1>
            <a href="admin_hotels.php" class="btn btn-back">← Back to Hotels</a>
        </div>

        <?php if ($error_message): ?>
            <div class="message error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="message success"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>

        <?php if ($hotel): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Hotel Name *</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($hotel['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($hotel['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price per Night ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($hotel['price']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($hotel['location']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="amenities">Amenities (comma separated)</label>
                    <input type="text" id="amenities" name="amenities" value="<?= htmlspecialchars($hotel['amenities'] ?? '') ?>" placeholder="WiFi, Pool, Spa, Gym...">
                </div>

                <div class="form-group">
                    <label for="rating">Rating (1-5)</label>
                    <select id="rating" name="rating">
                        <option value="1" <?= $hotel['rating'] == 1 ? 'selected' : '' ?>>1 Star</option>
                        <option value="2" <?= $hotel['rating'] == 2 ? 'selected' : '' ?>>2 Stars</option>
                        <option value="3" <?= $hotel['rating'] == 3 ? 'selected' : '' ?>>3 Stars</option>
                        <option value="4" <?= $hotel['rating'] == 4 ? 'selected' : '' ?>>4 Stars</option>
                        <option value="5" <?= $hotel['rating'] == 5 ? 'selected' : '' ?>>5 Stars</option>
                    </select>
                </div>

                <button type="submit" class="btn">Update Hotel</button>
            </form>
        <?php else: ?>
            <div class="message error">Hotel not found!</div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>