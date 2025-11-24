<?php
require 'db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $reviews_stmt = $pdo->query("
        SELECT r.*, u.name as user_name 
        FROM reviews r 
        LEFT JOIN users u ON r.user_id = u.id 
        ORDER BY r.date DESC
    ");
    $reviews = $reviews_stmt->fetchAll();
} catch (PDOException $e) {
    $reviews = [];
}
?>

<?php include 'includes/template/DOCreview.php'; ?>
