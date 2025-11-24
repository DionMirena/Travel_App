<?php
require 'db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$hotel_id = (int)($_GET['id'] ?? 0);

if (!$hotel_id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT h.*, p.name as place_name, p.description as place_description 
    FROM hotels h 
    JOIN places p ON h.place_id = p.id 
    WHERE h.id = ?
");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch();

if (!$hotel) {
    echo "Hotel not found!";
    exit;
}

// Error handling
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'duplicate_booking':
            $error_message = 'You already have a booking for these dates. Please choose different dates.';
            break;
        case 'invalid_dates':
            $error_message = 'Invalid dates selected. Check-out must be after check-in.';
            break;
        case 'booking_failed':
            $error_message = 'Booking failed. Please try again.';
            break;
    }
}

$room_stmt = $pdo->prepare("SELECT * FROM rooms WHERE hotel_id = ?");
$room_stmt->execute([$hotel_id]);
$rooms = $room_stmt->fetchAll();
?>

<?php include 'includes/template/header.php'; ?>

<style>
.hotel-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
    align-items: start;
}

.hotel-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 20px;
}

.hotel-info {
    flex: 1;
}

.hotel-name {
    font-size: 2.2em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}

.place-name {
    font-size: 1.2em;
    color: #007bff;
    margin-bottom: 20px;
    display: block;
}

.hotel-description {
    font-size: 1.1em;
    line-height: 1.7;
    color: #555;
    margin-bottom: 25px;
}

.amenities-section {
    margin: 30px 0;
}

.amenities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.amenity-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}
.booking-sidebar {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    align-self: start;
}

.booking-price {
    font-size: 1.8em;
    font-weight: bold;
    color: #007bff;
    text-align: center;
    margin-bottom: 20px;
}

.booking-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #495057;
}

.form-group input,
.form-group select {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
}

.book-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
    transition: all 0.3s ease;
}

.book-btn:hover {
    background: linear-gradient(135deg, #218838, #1e9e8a);
    transform: translateY(-2px);
}

.rooms-section {
    margin: 30px 0;
}

.room-option {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 4px solid #007bff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.room-type {
    font-weight: bold;
    color: #2c3e50;
    font-size: 1.1em;
    margin-bottom: 5px;
}

.room-price {
    color: #28a745;
    font-weight: bold;
    font-size: 1.2em;
}

.room-description {
    color: #666;
    margin: 8px 0;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #f5c6cb;
    font-size: 14px;
}
.review-form {
    margin-bottom: 30px;
    padding: 20px;
    background: white;
    border-radius: 8px;
}

.review-item {
    background: white;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .hotel-container {
        grid-template-columns: 1fr;
    }
    
    .booking-sidebar {
        position: static;
    }
    
    .reviews-section {
        grid-column: 1;
    }
}
</style>

<main>
    <div class="hotel-container">
        <div class="hotel-info">
            <?php
            $hotel_image = 'assets/placeholder.jpg';
            if (!empty($hotel['image'])) {
                $images = explode(',', $hotel['image']);
                $first_image = trim($images[0]);
                if (!empty($first_image) && file_exists($first_image)) {
                    $hotel_image = $first_image;
                }
            }
            ?>
            <img src="<?= htmlspecialchars($hotel_image) ?>" 
                 alt="<?= htmlspecialchars($hotel['name']) ?>" 
                 class="hotel-image">
            
            <h1 class="hotel-name"><?= htmlspecialchars($hotel['name']) ?></h1>
            <span class="place-name">📍 <?= htmlspecialchars($hotel['place_name']) ?></span>
            
            <p class="hotel-description"><?= nl2br(htmlspecialchars($hotel['description'])) ?></p>

            <?php if (!empty($hotel['amenities'])): ?>
            <div class="amenities-section">
                <h3>Hotel Amenities</h3>
                <div class="amenities-grid">
                    <?php 
                    $amenities = explode(',', $hotel['amenities']);
                    foreach ($amenities as $amenity): 
                    ?>
                        <div class="amenity-item">
                            <span>✅</span>
                            <span><?= htmlspecialchars(trim($amenity)) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (count($rooms) > 0): ?>
            <div class="rooms-section">
                <h3>Available Room Types</h3>
                <?php foreach ($rooms as $room): ?>
                    <div class="room-option">
                        <div class="room-type"><?= htmlspecialchars($room['room_type']) ?></div>
                        <div class="room-price">$<?= number_format($room['price'], 2) ?> / night</div>
                        <div class="room-description"><?= htmlspecialchars($room['description']) ?></div>
                        <div style="color: #666; font-size: 0.9em;">
                            Available: <?= $room['quantity'] ?> rooms
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="booking-sidebar">
            <div class="booking-price">
                From $<?= number_format($hotel['price'], 2) ?>/night
            </div>
            
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="book.php" class="booking-form">
                <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
                
                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" name="checkin" id="checkin" required min="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" name="checkout" id="checkout" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                </div>
                
                <div class="form-group">
                    <label>Guests</label>
                    <select name="guests" required>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?= $i ?>" <?= $i == 2 ? 'selected' : '' ?>>
                                <?= $i ?> <?= $i == 1 ? 'Guest' : 'Guests' ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Room Type</label>
                    <select name="room_type" required>
                        <?php if (count($rooms) > 0): ?>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= htmlspecialchars($room['room_type']) ?>">
                                    <?= htmlspecialchars($room['room_type']) ?> - $<?= number_format($room['price'], 2) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="standard">Standard Room</option>
                            <option value="deluxe">Deluxe Room</option>
                            <option value="suite">Suite</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <button type="submit" class="book-btn">
                    Book Now
                </button>
            </form>
        </div>
            
            <?php
            $can_review = false;
            $user_booking_id = null;
            $user_review = null;
            $reviews = [];
            
            if (!empty($_SESSION['user_id'])) {
                $stmt = $pdo->prepare("
                    SELECT id 
                    FROM bookings 
                    WHERE user_id = ? 
                    AND hotel_id = ? 
                    LIMIT 1
                ");
                // $stmt->execute([$_SESSION['user_id'], $hotel_id]);
                // $user_booking = $stmt->fetch();
                
                // if ($user_booking) {
                //     $can_review = true;
                //     $user_booking_id = $user_booking['id'];
                    
                //     $stmt = $pdo->prepare("SELECT * FROM reviews WHERE user_id = ? AND hotel_id = ? AND  = ?");
                //     $stmt->execute([$_SESSION['user_id'], $hotel_id, $user_booking_id]);
                //     $user_review = $stmt->fetch();
                }
            // }
            
            $stmt = $pdo->prepare("
                SELECT r.*, u.name as user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.hotel_id = ? 
                ORDER BY r.created_at DESC
            ");
            // $stmt->execute([$hotel_id]);
            // $reviews = $stmt->fetchAll();
            // ?>
            
            <?php if ($can_review): ?>
                <div class="review-form">
                    <h4><?= isset($user_review) ? 'Update Your Review' : 'Write a Review' ?></h4>
                    <form id="reviewForm">
                        <input type="hidden" name="hotel_id" value="<?= $hotel_id ?>">
                        
                        <div style="margin-bottom: 15px;">
                            <label>Your Rating:</label>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star" data-rating="<?= $i ?>" style="cursor: pointer; font-size: 24px; color: <?= $i <= (isset($user_review) ? $user_review['rating'] : 0) ? '#ffc107' : '#ccc' ?>;">
                                        ★
                                    </span>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="<?= isset($user_review) ? $user_review['rating'] : 0 ?>">
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <label>Your Review:</label>
                            <textarea name="comment" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; height: 100px;" 
                                      placeholder="Share your experience..."><?= isset($user_review) ? htmlspecialchars($user_review['comment']) : '' ?></textarea>
                        </div>
                        
                        <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                            <?= isset($user_review) ? 'Update Review' : 'Submit Review' ?>
                        </button>
                    </form>
                    <div id="reviewMessage" style="margin-top: 10px;"></div>
                </div>
              
            <?php endif; ?>
            
            <div class="reviews-list">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <strong><?= htmlspecialchars($review['user_name']) ?></strong>
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span style="color: <?= $i <= $review['rating'] ? '#ffc107' : '#ccc' ?>;">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p style="margin: 0; color: #555;"><?= htmlspecialchars($review['comment']) ?></p>
                            <small style="color: #888; display: block; margin-top: 10px;">
                                <?= date('M j, Y', strtotime($review['created_at'])) ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkin = document.getElementById('checkin');
    const checkout = document.getElementById('checkout');
    
    if (checkin && checkout) {
        checkin.addEventListener('change', function() {
            if (this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkout.min = nextDay.toISOString().split('T')[0];
                
                if (checkout.value && checkout.value < checkout.min) {
                    checkout.value = checkout.min;
                }
            }
        });
    }

    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('ratingInput');
    const reviewForm = document.getElementById('reviewForm');
    const reviewMessage = document.getElementById('reviewMessage');
    
    if (stars.length > 0 && ratingInput) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                
                stars.forEach(s => {
                    const starRating = s.getAttribute('data-rating');
                    s.style.color = starRating <= rating ? '#ffc107' : '#ccc';
                });
            });
        });
    }
    
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('submit_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                reviewMessage.innerHTML = `<div style="color: ${data.success ? 'green' : 'red'};">${data.message}</div>`;
                
                if (data.success) {
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                reviewMessage.innerHTML = '<div style="color: red;">An error occurred. Please try again.</div>';
            });
        });
    }
});
</script>

<?php include 'includes/template/footer.php'; ?>