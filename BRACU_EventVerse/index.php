<?php
require_once 'config/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRACU Eventverse - Your University Event Hub</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/">BRACU<span>eventverse</span></a>
            </div>
            <div class="nav-links">
                <a href="#events">Events</a>
                <a href="#clubs">Clubs</a>
                <a href="#about">About</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="pages/profile.php">Profile</a>
                    <a href="pages/logout.php">Logout</a>
                <?php else: ?>
                    <a href="pages/login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Don't miss out!</h1>
            <p>Dive into the vibrant world of university events and get involved!</p>
            <div class="countdown">
                <div class="time-block">
                    <span id="days">12</span>
                    <label>Days</label>
                </div>
                <div class="time-block">
                    <span id="hours">08</span>
                    <label>Hours</label>
                </div>
                <div class="time-block">
                    <span id="minutes">00</span>
                    <label>Minutes</label>
                </div>
            </div>
        </section>

        <section class="event-categories">
            <h2>Event Categories</h2>
            <div class="category-grid">
                <div class="category-card">
                    <i class="fas fa-laptop-code"></i>
                    <h3>Technical</h3>
                </div>
                <div class="category-card">
                    <i class="fas fa-music"></i>
                    <h3>Cultural</h3>
                </div>
                <div class="category-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Academic</h3>
                </div>
                <div class="category-card">
                    <i class="fas fa-users"></i>
                    <h3>Social</h3>
                </div>
                <div class="category-card">
                    <i class="fas fa-trophy"></i>
                    <h3>Sports</h3>
                </div>
            </div>
        </section>

        <section class="trending-events">
            <h2>Trending Events around the Campus</h2>
            <div class="event-grid">
                <!-- Events will be dynamically loaded here -->
            </div>
            <button class="view-more">View More</button>
        </section>

        <section class="popular-events">
            <h2>Popular Events</h2>
            <div class="event-grid">
                <!-- Popular events will be loaded here -->
            </div>
            <button class="view-more">View More</button>
        </section>

        <section class="create-event">
            <div class="create-event-content">
                <h2>Create an event with Security</h2>
                <p>Want to organize your own event? Get started now!</p>
                <button class="create-btn">Create Event</button>
            </div>
        </section>

        <section class="global-map">
            <h2>Global reach</h2>
            <div class="map-container">
                <!-- World map visualization will go here -->
            </div>
        </section>

        <section class="newsletter">
            <h2>Subscribe to our Newsletter</h2>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="footer-content">
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
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#clubs">Clubs</a></li>
                    <li><a href="#about">About</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 BRACU Eventverse. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
