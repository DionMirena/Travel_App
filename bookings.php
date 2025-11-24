<?php
require 'db.php';

if (empty($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$stmt = $pdo->prepare("SELECT b.*, h.name as hotel_name, p.name as place_name 
                       FROM bookings b 
                       JOIN hotels h ON b.hotel_id = h.id 
                       JOIN places p ON h.place_id = p.id 
                       WHERE b.user_id = ? 
                       ORDER BY b.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();
?>
<?php include 'includes/template/header.php'; ?>
        <h1>My Booking History</h1>
        
        <?php if (count($bookings) > 0): ?>
            <?php foreach($bookings as $booking): ?>
                <div class="booking-card">
                    <div class="booking-header">
                        <h3><?= htmlspecialchars($booking['hotel_name']) ?> - <?= htmlspecialchars($booking['place_name']) ?></h3>
                        <span class="<?= strtotime($booking['check_out']) > time() ? 'status-upcoming' : 'status-completed' ?>">
                            <?= strtotime($booking['check_out']) > time() ? 'Upcoming Stay' : 'Completed' ?>
                        </span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <p><strong>Check-in:</strong> <?= date('F j, Y', strtotime($booking['check_in'])) ?></p>
                            <p><strong>Check-out:</strong> <?= date('F j, Y', strtotime($booking['check_out'])) ?></p>
                        </div>
                        <div>
                            <p><strong>Guests:</strong> <?= htmlspecialchars($booking['guests']) ?></p>
                            <p><strong>Booked on:</strong> <?= date('F j, Y', strtotime($booking['created_at'])) ?></p>
                        </div>
                    </div>
                    
                    <?php if (strtotime($booking['check_out']) > time()): ?>
                        <div style="margin-top: 15px;">
                            <a href="hotel.php?id=<?= $booking['hotel_id'] ?>" class="btn">View Hotel</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px;">
                <h3>No bookings found</h3>
                <p>You haven't made any bookings yet.</p>
                <a href="index.php" class="btn">Explore Places to Book</a>
            </div>
        <?php endif; ?>

<?php include 'includes/template/footer.php'; ?>
