<?php 
include('config/database.php'); 
include('partials-front/menu.php');

// Handle contact form submission
if(isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Save to database
    $insert = "INSERT INTO tbl_contacts (name, email, subject, message, created_at, status) 
               VALUES ('$name', '$email', '$subject', '$message', NOW(), 'unread')";
    
    if(mysqli_query($conn, $insert)) {
        $success = "Thank you for contacting us! We'll get back to you soon.";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>

<style>
    .contact-page {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .contact-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .contact-header h1 {
        font-size: 48px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }
    
    .contact-header p {
        font-size: 18px;
        color: #666;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
    }
    
    .contact-info {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .contact-info h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1a1a2e;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        background: #fff0f0;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    
    .info-text h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .info-text p {
        color: #666;
        margin: 0;
    }
    
    .contact-form {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .contact-form h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1a1a2e;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s;
    }
    
    .form-group input:focus, .form-group textarea:focus {
        outline: none;
        border-color: #ff6b6b;
    }
    
    .btn-submit {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
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
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .map-container {
        margin-top: 50px;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .map-container iframe {
        width: 100%;
        height: 400px;
        border: none;
    }
    
    .success-msg {
        background: #dcfce7;
        color: #16a34a;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .error-msg {
        background: #fee2e2;
        color: #dc2626;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
        .contact-header h1 {
            font-size: 32px;
        }
    }
</style>

<section class="contact-page">
    <div class="container">
        <div class="contact-header">
            <h1>📞 Contact Us</h1>
            <p>We'd love to hear from you! Reach out with any questions or feedback.</p>
        </div>
        
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Get in Touch</h2>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-text">
                        <h4>Visit Us</h4>
                        <p>123 Food Street, MG Road, Pune - 411001</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-text">
                        <h4>Call Us</h4>
                        <p>+91 98765 43210</p>
                        <p>+91 87654 32109</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-text">
                        <h4>Email Us</h4>
                        <p>info@foodhub.com</p>
                        <p>support@foodhub.com</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-text">
                        <h4>Working Hours</h4>
                        <p>Monday - Sunday: 9:00 AM - 11:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h2>Send a Message</h2>
                
                <?php if(isset($success)): ?>
                    <div class="success-msg">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                    <div class="error-msg">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" name="send_message" class="btn-submit">Send Message →</button>
                </form>
            </div>
        </div>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.0793730917797!2d73.85624801489483!3d18.520430787411182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c06a6adf6c15%3A0x3b6b8d9c3a6b8d9c!2sPune%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>