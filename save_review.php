<?php
require 'db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$name = $_POST['name'] ?? '';
$rating = $_POST['rating'] ?? 0;
$review_text = $_POST['review'] ?? '';
$hotel_id = $_POST['hotel_id'] ?? null;

if (empty($name) || empty($rating) || empty($review_text)) {
    header("Location: index.php?review_message=Please fill all fields&review_type=error");
    exit();
}

if ($rating < 1 || $rating > 5) {
    header("Location: index.php?review_message=Please select a valid rating&review_type=error");
    exit();
}

try {
    $sql = "INSERT INTO reviews (user_id, name, rating, review, hotel_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    $success = $stmt->execute([
        $_SESSION['user_id'],
        $name,
        $rating,
        $review_text,
        $hotel_id
    ]);

    if ($success) {
        header("Location: profile.php?review_success=1&message=Thank you for your review!");
    } else {
        header("Location: index.php?review_message=Error submitting review. Please try again.&review_type=error");
    }
} catch (PDOException $e) {
    header("Location: index.php?review_message=Database error. Please try again.&review_type=error");
}
?>