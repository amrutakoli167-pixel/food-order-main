<?php 
session_start();
include('config/database.php'); 
include('partials-front/menu.php');

$error = '';
$success = '';

// Handle feedback submission
if(isset($_POST['submit_feedback'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $rating = (int)$_POST['rating'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Get user_id if logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    
    $insert = "INSERT INTO feedback (user_id, user_name, user_email, rating, message, status, created_at) 
               VALUES ('$user_id', '$user_name', '$user_email', '$rating', '$message', 'pending', NOW())";
    
    // Debug - SQL query दिसेल (View Page Source मध्ये)
    echo "<!-- Debug SQL: " . $insert . " -->";
    
    if(mysqli_query($conn, $insert)) {
        $success = "Thank you for your valuable feedback! We appreciate your input.";
        echo "<!-- Debug: Insert Success -->";
    } else {
        $error = "Something went wrong: " . mysqli_error($conn);
        echo "<!-- Debug Error: " . mysqli_error($conn) . " -->";
    }
}

// Get approved feedbacks to display
$feedback_query = "SELECT * FROM feedback WHERE status='approved' ORDER BY created_at DESC LIMIT 10";
$feedback_result = mysqli_query($conn, $feedback_query);
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .feedback-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        padding: 80px 0;
        min-height: 80vh;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Header Section */
    .feedback-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .feedback-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .feedback-header p {
        font-size: 18px;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Grid Layout */
    .feedback-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }
    
    /* Feedback Form Card */
    .form-card {
        background: white;
        border-radius: 30px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .form-card:hover {
        transform: translateY(-5px);
    }
    
    .form-card h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    
    .form-card h2 i {
        color: #ff6b6b;
        margin-right: 10px;
    }
    
    .form-card p {
        color: #666;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    /* Rating Stars */
    .rating-section {
        margin-bottom: 25px;
    }
    
    .rating-label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block;
        color: #333;
    }
    
    .stars {
        display: flex;
        gap: 10px;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .stars input {
        display: none;
    }
    
    .stars label {
        font-size: 30px;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .stars label:hover,
    .stars label:hover ~ label,
    .stars input:checked ~ label {
        color: #ffc107;
    }
    
    /* Form Inputs */
    .input-group {
        margin-bottom: 20px;
    }
    
    .input-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
    }
    
    .input-group input,
    .input-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    
    .input-group input:focus,
    .input-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102,126,234,0.3);
    }
    
    /* Feedback Display Card */
    .display-card {
        background: white;
        border-radius: 30px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .display-card h2 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 25px;
    }
    
    .display-card h2 i {
        color: #ffc107;
        margin-right: 10px;
    }
    
    /* Feedback Items */
    .feedback-item {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s;
        border-left: 4px solid #667eea;
    }
    
    .feedback-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .feedback-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 18px;
    }
    
    .user-name {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    .feedback-date {
        font-size: 12px;
        color: #999;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 14px;
    }
    
    .feedback-message {
        color: #555;
        line-height: 1.6;
        margin-top: 12px;
        padding-left: 57px;
    }
    
    /* Empty State */
    .empty-feedback {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-feedback i {
        font-size: 64px;
        color: #ff6b6b;
        margin-bottom: 20px;
    }
    
    .empty-feedback h3 {
        font-size: 20px;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    
    .empty-feedback p {
        color: #666;
    }
    
    /* Alert Messages */
    .alert {
        padding: 12px 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border-left: 4px solid #16a34a;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    
    @media (max-width: 768px) {
        .feedback-grid {
            grid-template-columns: 1fr;
        }
        .feedback-header h1 {
            font-size: 32px;
        }
        .form-card, .display-card {
            padding: 25px;
        }
        .feedback-message {
            padding-left: 0;
        }
    }
</style>

<section class="feedback-page">
    <div class="container">
        <div class="feedback-header">
            <h1>💬 Your Feedback Matters!</h1>
            <p>Help us improve FoodHub with your valuable feedback</p>
        </div>
        
        <div class="feedback-grid">
            <!-- Feedback Form -->
            <div class="form-card">
                <h2><i class="fas fa-pen"></i> Share Your Experience</h2>
                <p>Tell us what you think about our food and service</p>
                
                <?php if($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="rating-section">
                        <label class="rating-label">Your Rating *</label>
                        <div class="stars">
                            <input type="radio" name="rating" value="5" id="star5" required>
                            <label for="star5"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="4" id="star4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="3" id="star3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="2" id="star2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" name="rating" value="1" id="star1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>Your Name *</label>
                        <input type="text" name="user_name" placeholder="Enter your name" 
                               value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Your Email *</label>
                        <input type="email" name="user_email" placeholder="Enter your email" 
                               value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Your Feedback *</label>
                        <textarea name="message" rows="4" placeholder="Tell us about your experience..." required></textarea>
                    </div>
                    
                    <button type="submit" name="submit_feedback" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            </div>
            
            <!-- Feedback Display -->
            <div class="display-card">
                <h2><i class="fas fa-star"></i> What Our Customers Say</h2>
                
                <?php if($feedback_result && mysqli_num_rows($feedback_result) > 0): ?>
                    <?php while($fb = mysqli_fetch_assoc($feedback_result)): ?>
                        <div class="feedback-item">
                            <div class="feedback-header-row">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <?php echo strtoupper(substr($fb['user_name'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <div class="user-name"><?php echo htmlspecialchars($fb['user_name']); ?></div>
                                        <div class="rating-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $fb['rating']): ?>
                                                    <i class="fas fa-star"></i>
                                                <?php else: ?>
                                                    <i class="far fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="feedback-date">
                                    <?php echo date('d M Y', strtotime($fb['created_at'])); ?>
                                </div>
                            </div>
                            <div class="feedback-message">
                                <i class="fas fa-quote-left" style="color: #667eea; margin-right: 8px;"></i>
                                <?php echo nl2br(htmlspecialchars($fb['message'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-feedback">
                        <i class="fas fa-comment-dots"></i>
                        <h3>No Feedback Yet</h3>
                        <p>Be the first to share your experience with us!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>