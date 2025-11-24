<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to submit a review']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = (int)($_POST['hotel_id'] ?? 0);
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    $user_id = $_SESSION['user_id'];

    if ($hotel_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid hotel']);
        exit;
    }

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Rating must be between 1-5']);
        exit;
    }

    if (empty($comment)) {
        echo json_encode(['success' => false, 'message' => 'Please enter a comment']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            SELECT id 
            FROM bookings 
            WHERE user_id = ? 
            AND hotel_id = ? 
            AND check_out < CURDATE()
            LIMIT 1
        ");
        $stmt->execute([$user_id, $hotel_id]);
        $booking = $stmt->fetch();

        if (!$booking) {
            echo json_encode([
                'success' => false, 
                'message' => 'You can only review hotels you have booked and completed your stay'
            ]);
            exit;
        }

        $booking_id = $booking['id'];

        $stmt = $pdo->prepare("SELECT id FROM reviews WHERE user_id = ? AND hotel_id = ? AND booking_id = ?");
        $stmt->execute([$user_id, $hotel_id, $booking_id]);
        
        if ($existing_review = $stmt->fetch()) {
            $stmt = $pdo->prepare("UPDATE reviews SET rating = ?, comment = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$rating, $comment, $existing_review['id']]);
            $message = "Review updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO reviews (user_id, hotel_id, booking_id, rating, comment) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $hotel_id, $booking_id, $rating, $comment]);
            $message = "Review submitted successfully!";
        }

        echo json_encode(['success' => true, 'message' => $message]);
        
    } catch (Exception $e) {
        error_log("Review error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>