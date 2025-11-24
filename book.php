<?php
require 'db.php';

if (empty($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = (int)$_POST['hotel_id'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $guests = (int)$_POST['guests'];
    $room_type = $_POST['room_type'] ?? 'standard';
    
    $user_stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
    $user_stmt->execute([$_SESSION['user_id']]);
    $user = $user_stmt->fetch();
    
    if (!$user) {
        header("Location: login.php?error=user_not_found");
        exit;
    }
    
    $duplicate_stmt = $pdo->prepare("
        SELECT id FROM bookings 
        WHERE user_id = ? 
        AND (
            (check_in BETWEEN ? AND ?) 
            OR (check_out BETWEEN ? AND ?)
            OR (? BETWEEN check_in AND check_out)
        )
    ");
    $duplicate_stmt->execute([
        $_SESSION['user_id'],
        $check_in, $check_out,
        $check_in, $check_out,
        $check_in
    ]);
    
    if ($duplicate_stmt->fetch()) {
        header("Location: hotel.php?id=$hotel_id&error=duplicate_booking");
        exit;
    }
    
    $checkin_date = new DateTime($check_in);
    $checkout_date = new DateTime($check_out);
    $days = $checkout_date->diff($checkin_date)->days;
    
    if ($days <= 0) {
        header("Location: hotel.php?id=$hotel_id&error=invalid_dates");
        exit;
    }
    
    $hotel_stmt = $pdo->prepare("SELECT price, name FROM hotels WHERE id = ?");
    $hotel_stmt->execute([$hotel_id]);
    $hotel = $hotel_stmt->fetch();
    
    if (!$hotel) {
        header("Location: index.php?error=hotel_not_found");
        exit;
    }
    
    $total_amount = $days * $hotel['price'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, user_name, user_email, hotel_id, check_in, check_out, guests, room_type, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user['id'],
            $user['name'],
            $user['email'],
            $hotel_id,
            $check_in,
            $check_out,
            $guests,
            $room_type,
            $total_amount
        ]);
        
        $booking_id = $pdo->lastInsertId();
        header("Location: index.php?booking_success=1&booking_id=" . $booking_id);
        exit;
        
    } catch (PDOException $e) {
        header("Location: hotel.php?id=$hotel_id&error=booking_failed");
        exit;
    }
}


header("Location: index.php");
exit;
?>
header("Location: index.php");
exit;
?>