<?php
require 'db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$place_id = (int)($_GET['id'] ?? 0);

if (!$place_id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM places WHERE id = ?");
$stmt->execute([$place_id]);
$place = $stmt->fetch();

if (!$place) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM hotels WHERE place_id = ?");
$stmt->execute([$place_id]);
$hotels = $stmt->fetchAll();
?>

<?php include 'includes/template/header.php'; ?>

<style>
.place-hero {
    position: relative;
    height: 300px;
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?= !empty($place['image']) ? explode(',', $place['image'])[0] : 'assets/placeholder.jpg' ?>');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    margin-bottom: 40px;
}

.place-hero-content {
    max-width: 800px;
    padding: 0 20px;
}

.place-title {
    font-size: 2.5em;
    font-weight: bold;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.place-details {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.place-description {
    font-size: 1.1em;
    line-height: 1.8;
    color: #555;
    margin-bottom: 40px;
    text-align: center;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.hotels-section {
    margin-top: 40px;
}

.section-title {
    font-size: 2em;
    text-align: center;
    margin-bottom: 30px;
    color: #2c3e50;
}

.hotels-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.hotel-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.hotel-card:hover {
    transform: translateY(-5px);
}

.hotel-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.hotel-content {
    padding: 20px;
}

.hotel-name {
    font-size: 1.4em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}

.hotel-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    font-size: 0.9em;
}

.amenities {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.amenity {
    background: #f8f9fa;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8em;
    color: #495057;
    border: 1px solid #e9ecef;
}

.hotel-price {
    font-size: 1.3em;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 15px;
}

.details-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
    text-align: center;
}

.details-btn:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
}

.no-hotels {
    text-align: center;
    padding: 40px 20px;
    color: #666;
}

.back-link {
    display: inline-flex;
    align-items: center;
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 20px;
}

.amenities {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.amenity {
    background: #f8f9fa;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.8em;
    color: #495057;
    border: 1px solid #e9ecef;
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
</style>

<main>
    <section class="place-hero">
        <div class="place-hero-content">
            <h1 class="place-title"><?= htmlspecialchars($place['name']) ?></h1>
        </div>
    </section>

    <div class="place-details">
        <section class="place-description">
            <p><?= nl2br(htmlspecialchars($place['description'])) ?></p>
        </section>

        <section class="hotels-section">
            <h2 class="section-title">Available Hotels</h2>
            
<?php if (count($hotels) > 0): ?>
    <div class="hotels-grid">
        <?php foreach ($hotels as $hotel): ?>
            <div class="hotel-card">
                <?php
                $hotel_image = 'assets/placeholder.jpg';
                if (!empty($hotel['image'])) {
                    $images = explode(',', $hotel['image']);
                    $first_image = trim($images[0]);
                    if (!empty($first_image)) {
                        $hotel_image = $first_image;
                    }
                }
                ?>
                <img src="<?= htmlspecialchars($hotel_image) ?>" 
                     alt="<?= htmlspecialchars($hotel['name']) ?>" 
                     class="hotel-image">
                
                <div class="hotel-content">
                    <h3 class="hotel-name"><?= htmlspecialchars($hotel['name']) ?></h3>
                    <p class="hotel-description"><?= htmlspecialchars($hotel['description']) ?></p>
                    
                    <?php if (!empty($hotel['amenities'])): ?>
                        <div class="amenities">
                            <?php 
                            $amenities = explode(',', $hotel['amenities']);
                            foreach ($amenities as $amenity): 
                            ?>
                                <span class="amenity"><?= htmlspecialchars(trim($amenity)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="hotel-price">
                        $<?= number_format($hotel['price'], 2) ?> / night
                    </div>
                    
                    <a href="hotel.php?id=<?= $hotel['id'] ?>" class="details-btn">
                        View Details & Book
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="no-hotels">
        <h3>No hotels available in <?= htmlspecialchars($place['name']) ?></h3>
        <p>Check back later for new accommodation options.</p>
    </div>
<?php endif; ?>
        </section>
    </div>
</main>

<?php include 'includes/template/footer.php'; ?>