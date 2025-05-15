<?php
$page_title = "BRACU Eventverse - About Us";
require_once '../config/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    .about-header {
        background: linear-gradient(135deg, #6C2BD9 0%, #8B5CF6 100%);
        color: black;
        padding: 60px 0;
        margin-bottom: 40px;
        text-align: center;
    }
    .feature-card {
        background: black;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        text-align: center;
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
    .feature-icon {
        font-size: 2rem;
        color: #6C2BD9;
        margin-bottom: 15px;
    }
    .feedback-section {
        background:rgb(2, 6, 9);
        padding: 60px 0;
        margin-top: 40px;
        border-radius: 15px;
        display: flex;
        justify-content: center;
    }
    .feedback-form {
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .section-title {
        color: #6C2BD9;
        margin-bottom: 30px;
        font-weight: bold;
        text-align: center;
    }
    .form-label {
        font-size: 16px;
        margin-bottom: 6px;
        display: block;
        text-align: left;
        color: #fff;
    }
    .form-control {
        padding: 12px 15px;
        font-size: 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        width: 100%;
        box-sizing: border-box;
    }
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
        text-align: left;
    }
    .btn-submit {
        background: #6C2BD9;
        color: white;
        padding: 12px 40px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background: #5620B0;
        transform: translateY(-2px);
    }
    .mb-3 {
        margin-bottom: 20px;
    }
    .mb-4 {
        margin-bottom: 30px;
    }
    .text-primary {
        color: #6C2BD9 !important;
    }
    .row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    .col-md-6 {
        flex: 1;
        min-width: 0;
    }
</style>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="./">BRACU<span>eventverse</span></a>
            </div>
            <div class="nav-links">
                <a href="./events.php">Events</a>
                <a href="./clubs.php">Clubs</a>
                <a href="./register_event.php">Register</a>
                <a href="./certificates.php">Certificates</a>
                <a href="./about.php">About</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="./profile.php">Profile</a>
                <a href="../sql/logout.php">Logout</a>
                <?php else: ?>
                <a href="pages/login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="py-5">

    <!-- About Header Section -->
    <div class="about-header">
        <div class="container">
            <h1 class="display-4">Welcome to BRACU EventVerse</h1>
            <p class="lead">Your Ultimate University Event Management Platform</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Features Section -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-calendar-check feature-icon"></i>
                    <h4>Event Management</h4>
                    <p>Easy registration and coordination for all university events. Stay updated with upcoming activities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-users feature-icon"></i>
                    <h4>Club Activities</h4>
                    <p>Seamless club management and coordination. Connect with club members and organize events efficiently.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-door-open feature-icon"></i>
                    <h4>Room Booking</h4>
                    <p>Smart room allocation system for events. Book venues and manage schedules hassle-free.</p>
                </div>
            </div>
        </div>

        <!-- Feedback Section -->
        <div class="feedback-section">
            <div class="container">
                <h1 class="section-title">Share Your Feedback</h1>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="feedback-form">
                            <form action="../sql/submit_feedback.php" method="POST" id="feedbackForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <i class="fas fa-user text-primary me-2"></i>Your Name
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope text-primary me-2"></i>Your Email
                                            </label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="form-label">
                                        <i class="fas fa-comment text-primary me-2"></i>Your Feedback
                                    </label>
                                    <textarea class="form-control" id="message" name="message" rows="4" 
                                        placeholder="We value your feedback! Share your thoughts with us..." required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-submit">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div id="footer_section" class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>BRACU Eventverse is your one-stop platform for all university events.</p>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: support@bracueventverse.com</p>
                <p>Phone: +880 123 456 789</p>
            </div>
            <div class="footer-section">
                <h3>Stay Connected</h3>
                <ul>
                    <li><a href="#events">Facebook</a></li>
                    <li><a href="#clubs">Twitter</a></li>
                    <li><a href="#about">Instagram</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 BRACU Eventverse. All rights reserved.</p>
        </div>
    </footer>

    <script>
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to submit this feedback?')) {
            this.submit();
        }
    });
    </script>

    <script src="../assets/js/main.js"></script>
</body>
</html>