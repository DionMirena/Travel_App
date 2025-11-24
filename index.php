<?php
require 'db.php'; 

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$placeholder_path = 'assets/placeholder.jpg';
if (!file_exists($placeholder_path)) {
    $im = imagecreate(200, 150);
    $bg_color = imagecolorallocate($im, 240, 240, 240);
    $text_color = imagecolorallocate($im, 150, 150, 150);
    imagestring($im, 3, 60, 65, 'No Image', $text_color);
    imagejpeg($im, $placeholder_path, 80);
    imagedestroy($im);
}

$search = trim($_GET['search'] ?? '');

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM places WHERE name LIKE ? OR description LIKE ?");
    $like = "%$search%";
    $stmt->execute([$like, $like]);
} else {
    $stmt = $pdo->query("SELECT * FROM places ORDER BY name");
}
$places = $stmt->fetchAll();

$reviews_stmt = $pdo->query("
    SELECT r.*, h.name as hotel_name, h.id as hotel_id, h.place_id
    FROM reviews r 
    LEFT JOIN hotels h ON r.hotel_id = h.id 
    ORDER BY r.date DESC
");
$reviews = $reviews_stmt->fetchAll();

$sort = $_GET['sort'] ?? 'newest';
if ($sort === 'oldest') {
    usort($reviews, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
} else {
    usort($reviews, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
}
?>

<?php include 'includes/template/header.php'; ?>

<style>
.places-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 30px;
    padding: 0 20px;
}
.place-card {
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 0;
    background: white;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}
.place-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.place-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
}
.place-content {
    padding: 20px;
}
.place-name {
    font-size: 1.5em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}
.place-description {
    color: #555;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 14px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 80px;
}
.details-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    cursor: button;
    font-size: 16px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
}
.details-btn:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-2px);
}
.search-section {
    text-align: center;
    margin: 30px 0;
    padding: 0 20px;
}
.search-section input {
    padding: 12px 15px;
    width: 400px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
    margin-right: 10px;
}
.search-section button {
    padding: 12px 25px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
}
.success-message {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #4CAF50;
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    animation: slideIn 0.5s ease-out;
}
@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.no-places {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
}
.no-places h3 {
    color: #666;
    margin-bottom: 10px;
}
.no-places p {
    color: #888;
}

.review-form {
    background: white;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.form-group {
    margin-bottom: 20px;
}
.review-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2c3e50;
}
.review-form input[type="text"],
.review-form textarea,
.review-form select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}
.review-form textarea {
    resize: vertical;
    min-height: 120px;
}
.rating {
    margin: 15px 0;
    font-size: 24px;
    color: #f39c12;
    cursor: pointer;
}
.rating span {
    margin-right: 5px;
    transition: color 0.2s;
}
.rating span:hover {
    color: #e67e22;
}
.submit-btn {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
    width: 100%;
}
.submit-btn:hover {
    background-color: #2980b9;
}
.review-item {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #3498db;
}
.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.review-author {
    font-weight: bold;
    color: #2c3e50;
}
.review-date {
    color: #7f8c8d;
    font-size: 14px;
}
.no-reviews {
    text-align: center;
    padding: 30px;
    color: #7f8c8d;
    font-style: italic;
    background-color: #f9f9f9;
    border-radius: 5px;
}
.review-stars {
    color: #f39c12;
    margin-bottom: 10px;
}
.review-message {
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    text-align: center;
}
.review-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.review-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Reviews Carousel Styles */
.reviews-carousel-container {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 12px;
}
.carousel-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
}
.carousel-slide {
    min-width: 100%;
    flex-shrink: 0;
    padding: 0 20px;
    box-sizing: border-box;
}
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(52, 152, 219, 0.8);
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}
.carousel-btn:hover {
    background: rgba(41, 128, 185, 0.9);
    transform: translateY(-50%) scale(1.1);
}
.prev-btn {
    left: 10px;
}
.next-btn {
    right: 10px;
}
.carousel-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}
.indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: #bdc3c7;
    cursor: pointer;
    transition: background 0.3s ease;
}
.indicator.active {
    background: #3498db;
}
.indicator:hover {
    background: #3498db;
}
.hotel-badge {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 0.9em;
    font-weight: bold;
    display: inline-block;
    margin-bottom: 15px;
}
.hotel-badge.general {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
}
.view-hotel-btn {
    background: #3498db;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9em;
    margin-top: 15px;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s ease;
}
.view-hotel-btn:hover {
    background: #2980b9;
    color: white;
    text-decoration: none;
}

.reviews-filter {
    text-align: center;
    margin-bottom: 30px;
}
.filter-btn {
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    padding: 10px 20px;
    margin: 0 5px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}
.filter-btn.active {
    background: #3498db;
    color: white;
    border-color: #3498db;
}
.filter-btn:hover {
    background: #e9ecef;
}

#chatbot {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    font-family: Arial, sans-serif;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    overflow: hidden;
    z-index: 1000;
}
#chatbot-header {
    background: #007bff;
    color: white;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    font-weight: bold;
}
#chatbot-body {
    background: white;
    display: none;
    flex-direction: column;
    height: 350px;
}
#chatbot-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #f9f9f9;
}
#chatbot-input-area {
    display: flex;
    border-top: 1px solid #ccc;
}
#chatbot-input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
    font-size: 14px;
}
#chatbot-send {
    padding: 10px 15px;
    border: none;
    background: #007bff;
    color: white;
    cursor: pointer;
    font-weight: bold;
}
#chatbot-send:hover {
    background: #0056b3;
}
.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 12px;
    max-width: 85%;
    word-wrap: break-word;
}
.user {
    background: #007bff;
    color: white;
    align-self: flex-end;
    margin-left: auto;
    border-bottom-right-radius: 4px;
}
.bot {
    background: #e9ecef;
    color: #333;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}
</style>

<?php if (isset($_GET['booking_success'])): ?>
    <div class="success-message" id="successMessage">
        ✅ Booking completed successfully!
    </div>
    <script>
        setTimeout(() => {
            const element = document.getElementById('successMessage');
            if (element) element.style.display = 'none';
        }, 5000);
    </script>
<?php endif; ?>

<main>
    <div class="hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 20px; text-align: center; border-radius: 10px; margin-bottom: 40px;">
        <h1 style="color: white; font-size: 2.5rem; margin-bottom: 20px;">Welcome to Travel App</h1>
        <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto 30px;">Discover amazing destinations and book your perfect stay with us.</p>
        <a href="#places" style="display: inline-block; background: #e74c3c; color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold;">Explore Destinations</a>
    </div>

    <section class="search-section">
        <form method="get" action="index.php">
            <input type="search" name="search" placeholder="Search for destinations..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </section>

    <section class="places-grid" id="places">
        <?php if (count($places) > 0): ?>
            <?php foreach ($places as $p): ?>
                <article class="place-card">
                    <?php
                    $image_path = $placeholder_path;
                    if (!empty($p['image']) && $p['image'] !== null) {
                        $images = explode(',', $p['image']);
                        $first_image = trim($images[0]);
                        if (!empty($first_image)) {
                            $image_path = $first_image;
                            if (!file_exists($image_path)) {
                                $image_path = $placeholder_path;
                            }
                        }
                    }
                    ?>
                    <img src="<?= htmlspecialchars($image_path) ?>" 
                         alt="<?= !empty($p['name']) ? htmlspecialchars($p['name']) : 'Place' ?>" 
                         class="place-image">
                    
                    <div class="place-content">
                        <div class="place-name"><?= !empty($p['name']) ? htmlspecialchars($p['name']) : 'Unnamed Place' ?></div>
                        <div class="place-description">
                            <?= !empty($p['description']) ? htmlspecialchars($p['description']) : 'No description available.' ?>
                        </div>
                        
                        <a href="place.php?id=<?= $p['id'] ?>" style="text-decoration: none;">
                            <button class="details-btn">
                                View Hotels & Book
                            </button>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-places">
                <h3>No places found</h3>
                <p>Try searching for a different destination.</p>
            </div>
        <?php endif; ?>
    </section>

    <section class="review-form-section" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); margin: 40px 0; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #2c3e50; text-align: center; margin-bottom: 30px; font-size: 2.2em;">Share Your Experience</h2>
        
        <?php if (isset($_GET['review_message'])): ?>
            <div class="review-message <?= $_GET['review_type'] ?? 'review-success' ?>" style="max-width: 600px; margin: 0 auto 30px;">
                <?= htmlspecialchars($_GET['review_message']) ?>
            </div>
        <?php endif; ?>
        
        <div class="review-form" style="background: white; padding: 30px; border-radius: 12px; max-width: 600px; margin: 0 auto; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
            <form method="POST" action="save_review.php">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label for="hotel_id">Select Hotel (Optional):</label>
                    <select id="hotel_id" name="hotel_id">
                        <option value="">General Review</option>
                        <?php
                        $hotels_stmt = $pdo->query("SELECT id, name FROM hotels ORDER BY name");
                        $hotels = $hotels_stmt->fetchAll();
                        foreach ($hotels as $hotel): ?>
                            <option value="<?= $hotel['id'] ?>"><?= htmlspecialchars($hotel['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rating">Your Rating:</label>
                    <div class="rating" id="ratingStars">
                        <span data-value="1">☆</span>
                        <span data-value="2">☆</span>
                        <span data-value="3">☆</span>
                        <span data-value="4">☆</span>
                        <span data-value="5">☆</span>
                    </div>
                    <input type="hidden" id="rating" name="rating" value="0" required>
                </div>
                
                <div class="form-group">
                    <label for="review">Your Review:</label>
                    <textarea id="review" name="review" placeholder="Tell us about your stay..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Submit Review</button>
            </form>
        </div>
    </section>

    <section class="reviews-carousel-section" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); margin: 40px 0; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #2c3e50; text-align: center; margin-bottom: 40px; font-size: 2.2em;">What Our Guests Say</h2>
        
        <div class="reviews-filter">
            <button class="filter-btn <?= $sort === 'newest' ? 'active' : '' ?>" onclick="window.location.href='index.php?sort=newest'">
                Newest First
            </button>
            <button class="filter-btn <?= $sort === 'oldest' ? 'active' : '' ?>" onclick="window.location.href='index.php?sort=oldest'">
                Oldest First
            </button>
        </div>
        
        <div class="reviews-carousel-container">
            <?php if (count($reviews) > 0): ?>
                <button class="carousel-btn prev-btn">‹</button>
                <button class="carousel-btn next-btn">›</button>
                
                <div class="carousel-track">
                    <?php foreach ($reviews as $index => $review): ?>
                        <div class="carousel-slide">
                            <div class="review-item" style="text-align: center; max-width: 600px; margin: 0 auto;">

                            <?php if (!empty($review['hotel_name'])): ?>
                                    <div class="hotel-badge">
                                         <?= htmlspecialchars($review['hotel_name']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="hotel-badge general">
                                         General Review
                                    </div>
                                <?php endif; ?>
                                
                                <div class="review-header" style="justify-content: center; gap: 20px;">
                                    <span class="review-author"><?= htmlspecialchars($review['name']) ?></span>
                                    <span class="review-date"><?= date('F j, Y', strtotime($review['date'])) ?></span>
                                </div>
                                <div class="review-stars">
                                    <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                                    <span style="color: #7f8c8d; font-size: 0.9em; margin-left: 10px;">(<?= $review['rating'] ?>/5)</span>
                                </div>
                                <p style="font-style: italic; color: #555; line-height: 1.6;">"<?= htmlspecialchars($review['review']) ?>"</p>
                                
                                <?php if (!empty($review['hotel_id']) && !empty($review['place_id'])): ?>
                                    <a href="place.php?id=<?= $review['place_id'] ?>&hotel_id=<?= $review['hotel_id'] ?>" class="view-hotel-btn">
                                         View This Hotel
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="carousel-indicators">
                    <?php foreach ($reviews as $index => $review): ?>
                        <button class="indicator <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-reviews">
                    <h3>No Reviews Yet</h3>
                    <p>Be the first to share your experience!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<div id="chatbot">
    <div id="chatbot-header">💬 Chat with us</div>
    <div id="chatbot-body">
        <div id="chatbot-messages"></div>
        <div id="chatbot-input-area">
            <input type="text" id="chatbot-input" placeholder="Ask me something..." />
            <button id="chatbot-send">Send</button>
        </div>
    </div>
</div>

<script>
const chatbotHeader = document.getElementById("chatbot-header");
const chatbotBody = document.getElementById("chatbot-body");
const chatbotMessages = document.getElementById("chatbot-messages");
const chatbotInput = document.getElementById("chatbot-input");
const chatbotSend = document.getElementById("chatbot-send");

let isFirstOpen = true;

chatbotHeader.addEventListener("click", () => {
    const isVisible = chatbotBody.style.display === "flex";
    chatbotBody.style.display = isVisible ? "none" : "flex";
    
    if (!isVisible && isFirstOpen) {
        setTimeout(() => {
            appendMessage("Hello! I'm your travel assistant. I can help you with: • Hotel bookings • Destination info • Travel tips • Booking questions. How can I help you today? ", "bot");
            isFirstOpen = false;
        }, 300);
    }
});

function appendMessage(text, sender) {
    const msg = document.createElement("div");
    msg.classList.add("message", sender);
    msg.textContent = text;
    chatbotMessages.appendChild(msg);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

async function sendMessage() {
    const userText = chatbotInput.value.trim();
    if (!userText) return;
    
    appendMessage(userText, "user");
    chatbotInput.value = "";

    try {
        const response = await fetch("chatbot.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "question=" + encodeURIComponent(userText)
        });

        const data = await response.text();
        appendMessage(data, "bot");
    } catch (error) {
        appendMessage("Sorry, I'm having trouble connecting right now. Please try again later.", "bot");
    }
}

chatbotSend.addEventListener("click", sendMessage);
chatbotInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") sendMessage();
});

const stars = document.querySelectorAll('#ratingStars span');
const ratingInput = document.getElementById('rating');

if (stars.length > 0) {
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingInput.value = value;
            
            stars.forEach((s, index) => {
                if (index < value) {
                    s.textContent = '★';
                    s.style.color = '#f39c12';
                } else {
                    s.textContent = '☆';
                    s.style.color = '#f39c12';
                }
            });
        });
    });

    document.querySelector('.review-form form').addEventListener('submit', function(e) {
        const rating = document.getElementById('rating').value;
        
        if (rating === '0') {
            e.preventDefault();
            alert('Please select a rating.');
            return;
        }
    });
}

function initReviewsCarousel() {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');
    
    if (!track || slides.length === 0) return;
    
    let currentIndex = 0;
    const totalSlides = slides.length;

    function updateCarousel() {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
        
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentIndex);
        });
    }

    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = totalSlides - 1;
        }
        updateCarousel();
    });

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });

    let autoSlide = setInterval(() => {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }, 5000);

    const carouselContainer = document.querySelector('.reviews-carousel-container');
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlide);
    });
    
    carouselContainer.addEventListener('mouseleave', () => {
        autoSlide = setInterval(() => {
            if (currentIndex < totalSlides - 1) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }
            updateCarousel();
        }, 5000);
    });

    updateCarousel();
}

document.addEventListener('DOMContentLoaded', initReviewsCarousel);
</script>

<?php include 'includes/template/footer.php'; ?>