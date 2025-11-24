<?php
require 'db.php';

if (empty($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?"); 
$stmt->execute([$_SESSION['user_id']]); 
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT b.*, h.name as hotel_name, p.name as place_name 
                       FROM bookings b 
                       JOIN hotels h ON b.hotel_id = h.id 
                       JOIN places p ON h.place_id = p.id 
                       WHERE b.user_id = ? 
                       ORDER BY b.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();

$reviews_stmt = $pdo->prepare("
    SELECT r.*, h.name as hotel_name, h.id as hotel_id 
    FROM reviews r 
    LEFT JOIN hotels h ON r.hotel_id = h.id 
    WHERE r.user_id = ? 
    ORDER BY r.date DESC
");
$reviews_stmt->execute([$_SESSION['user_id']]);
$user_reviews = $reviews_stmt->fetchAll();
?>

<?php include 'includes/template/header.php'?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Profile</title>
    <style>
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }
        .profile-info {
            flex: 1;
        }
        .booking-history {
            margin-top: 40px;
        }
        .booking-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background: #f9f9f9;
        }
        .booking-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .btn:hover {
            background: #0056b3;
        }
        
        .reviews-history {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .review-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .review-hotel {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
        }
        .review-date {
            color: #7f8c8d;
            font-size: 0.9em;
        }
        .review-rating {
            color: #f39c12;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .review-text {
            color: #555;
            line-height: 1.5;
            font-style: italic;
        }
        .no-reviews {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
            font-style: italic;
            background: #f9f9f9;
            border-radius: 8px;
            border: 2px dashed #ddd;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <main class="container profile-container">

    <?php if (isset($_GET['review_success'])): ?>
            <div class="success-message">
                 <?= isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Thank you for your review!' ?>
            </div>
        <?php endif; ?>

        <div class="profile-header">
            <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'assets/default-avatar.jpg' ?>" 
                 alt="Profile Picture" class="profile-pic">
            <div class="profile-info">
                <h1><?= htmlspecialchars($user['name']) ?></h1>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Member since:</strong> <?= date('F j, Y', strtotime($user['created_at'] ?? 'now')) ?></p>
                <a href="profile_edit.php" class="btn">Edit Profile</a>
            </div>
        </div>

        <section class="reviews-history">
            <h2>My Reviews</h2>
            <?php if (count($user_reviews) > 0): ?>
                <?php foreach($user_reviews as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-hotel">
                                <?php if (!empty($review['hotel_name'])): ?>
                                     <?= htmlspecialchars($review['hotel_name']) ?>
                                <?php else: ?>
                                     General Review
                                <?php endif; ?>
                            </div>
                            <span class="review-date">
                                <?= date('F j, Y', strtotime($review['date'])) ?>
                            </span>
                        </div>
                        <div class="review-rating">
                            <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                            <span style="color: #7f8c8d; font-size: 0.9em; margin-left: 10px;">
                                (<?= $review['rating'] ?>/5)
                            </span>
                        </div>
                        <div class="review-text">
                            "<?= htmlspecialchars($review['review']) ?>"
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-reviews">
                    <h3>No Reviews Yet</h3>
                    <p>You haven't submitted any reviews yet. <a href="index.php">Share your experience!</a></p>
                </div>
            <?php endif; ?>
        </section>

        <section class="booking-history">
            <h2>My Booking History</h2>
            <?php if (count($bookings) > 0): ?>
                <?php foreach($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3><?= htmlspecialchars($booking['hotel_name']) ?> - <?= htmlspecialchars($booking['place_name']) ?></h3>
                            <span style="color: #666; font-size: 0.9em;">
                                Booked on: <?= date('M j, Y', strtotime($booking['created_at'])) ?>
                            </span>
                        </div>
                        <p><strong>Check-in:</strong> <?= date('M j, Y', strtotime($booking['check_in'])) ?></p>
                        <p><strong>Check-out:</strong> <?= date('M j, Y', strtotime($booking['check_out'])) ?></p>
                        <p><strong>Guests:</strong> <?= htmlspecialchars($booking['guests']) ?></p>
                        <p><strong>Status:</strong> 
                            <span style="color: <?= strtotime($booking['check_out']) > time() ? 'green' : 'gray' ?>;">
                                <?= strtotime($booking['check_out']) > time() ? 'Upcoming' : 'Completed' ?>
                            </span>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No bookings found. <a href="index.php">Start exploring places to book!</a></p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>