<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Reviews - Travel App</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .reviews-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 40px 0;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .reviews-section h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-align: center;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }
        
        .review-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #3498db;
        }
        
        .review-form h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 1.8em;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .review-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1em;
        }
        
        .review-form input[type="text"],
        .review-form textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .review-form input[type="text"]:focus,
        .review-form textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .review-form textarea {
            resize: vertical;
            min-height: 150px;
            font-family: inherit;
        }
        
        .rating {
            margin: 15px 0;
            font-size: 28px;
            color: #f39c12;
            cursor: pointer;
        }
        
        .rating span {
            margin-right: 8px;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .rating span:hover {
            color: #e67e22;
            transform: scale(1.2);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 15px 35px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .reviews-list {
            margin-top: 40px;
        }
        
        .reviews-list h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 2em;
            text-align: center;
        }
        
        .review-item {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #3498db;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .review-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .review-author {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.2em;
        }
        
        .review-date {
            color: #7f8c8d;
            font-size: 0.9em;
            background: #ecf0f1;
            padding: 5px 10px;
            border-radius: 15px;
        }
        
        .no-reviews {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
            font-style: italic;
            background-color: #f9f9f9;
            border-radius: 10px;
            border: 2px dashed #bdc3c7;
        }
        
        .no-reviews h3 {
            color: #95a5a6;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        
        .review-stars {
            color: #f39c12;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .review-item p {
            color: #555;
            line-height: 1.7;
            font-size: 1.1em;
        }
        
        .review-message {
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            font-size: 1.1em;
        }
        
        .review-success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .review-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .reviews-section {
                padding: 25px 20px;
                margin: 20px 0;
            }
            
            .reviews-section h2 {
                font-size: 2em;
            }
            
            .review-form {
                padding: 20px;
            }
            
            .review-form h3 {
                font-size: 1.5em;
            }
            
            .rating {
                font-size: 24px;
            }
            
            .review-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .review-author {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="reviews-section">
            <h2>Guest Reviews</h2>
            
            <?php if (isset($_GET['message'])): ?>
                <div class="review-message <?= $_GET['type'] === 'success' ? 'review-success' : 'review-error' ?>">
                    <?= htmlspecialchars($_GET['message']) ?>
                </div>
            <?php endif; ?>
            
            <div class="review-form">
                <h3>Share Your Experience</h3>
                <form method="POST" action="save_review.php">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" id="name" name="name" required 
                               value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>"
                               placeholder="Enter your name">
                    </div>
                    
                    <div class="form-group">
                        <label for="rating">Your Rating:</label>
                        <div class="rating" id="ratingStars">
                            <span data-value="1" title="Poor">☆</span>
                            <span data-value="2" title="Fair">☆</span>
                            <span data-value="3" title="Good">☆</span>
                            <span data-value="4" title="Very Good">☆</span>
                            <span data-value="5" title="Excellent">☆</span>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <div style="color: #7f8c8d; font-size: 0.9em; margin-top: 5px;">
                            Click on the stars to rate your experience
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="review">Your Review:</label>
                        <textarea id="review" name="review" 
                                  placeholder="Tell us about your stay... What did you like? What could be improved?" 
                                  required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        Submit Your Review
                    </button>
                </form>
            </div>
            
            <div class="reviews-list">
                <h3>What Our Guests Say</h3>
                <div id="reviewsContainer">
                    <?php if (count($reviews) > 0): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="review-author">
                                        <?= htmlspecialchars($review['name']) ?>
                                    </span>
                                    <span class="review-date">
                                        <?= date('F j, Y', strtotime($review['date'])) ?>
                                    </span>
                                </div>
                                <div class="review-stars">
                                    <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                                    <span style="color: #7f8c8d; font-size: 0.9em; margin-left: 10px;">
                                        (<?= $review['rating'] ?>/5)
                                    </span>
                                </div>
                                <p><?= htmlspecialchars($review['review']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-reviews">
                            <h3>No Reviews Yet</h3>
                            <p>Be the first to share your experience with our community!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        const stars = document.querySelectorAll('#ratingStars span');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.textContent = '★';
                        s.style.color = '#f39c12';
                        s.style.transform = 'scale(1.1)';
                    } else {
                        s.textContent = '☆';
                        s.style.color = '#f39c12';
                        s.style.transform = 'scale(1)';
                    }
                });
            });
            
            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.style.color = '#e67e22';
                    }
                });
            });
            
            star.addEventListener('mouseout', function() {
                const currentRating = ratingInput.value;
                stars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.style.color = '#f39c12';
                    } else {
                        s.style.color = '#f39c12';
                    }
                });
            });
        });

        document.querySelector('.review-form form').addEventListener('submit', function(e) {
            const rating = document.getElementById('rating').value;
            const name = document.getElementById('name').value.trim();
            const review = document.getElementById('review').value.trim();
            
            if (rating === '0') {
                e.preventDefault();
                alert('Please select a rating by clicking on the stars.');
                return;
            }
            
            if (name === '') {
                e.preventDefault();
                alert('Please enter your name.');
                return;
            }
            
            if (review === '') {
                e.preventDefault();
                alert('Please write your review.');
                return;
            }
        });

        setTimeout(() => {
            const successMessage = document.querySelector('.review-success');
            if (successMessage) {
                successMessage.style.opacity = '0';
                successMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>