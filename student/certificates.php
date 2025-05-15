<?php
$page_title="BRACU Eventverse - Your University Event Hub";
require_once '../config/database.php';
include "../partials/header.php";
session_start();
if($_SESSION['role']!=='student'){
    header("Location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Certificate</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    a{
        color: white;
        text-decoration: none;
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
    <main class="py-5">
        <section class="Certification">
            <div style="text-align: center;">
                <div style="height: 1px;"></div>
        
                <h1><strong>Generate Your Certificate</strong></h1>
                
                <p>Fill in the details below to generate your event certificate.</p>
            </div>
        
    <form style="max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #020202;">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="Your Name" style="display: block; margin-bottom: 5px;">Your name</label>
            <input type="Your Name" class="form-control" id="Your Name" aria-describedby="Your Name" placeholder="Your Name" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="Event Name" style="display: block; margin-bottom: 5px;">Event Name</label>
            <input type="Event Name" class="form-control" id="Event Name" placeholder="Event Name" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="Date of Event" style="display: block; margin-bottom: 5px;">Date of Event</label>
            <input type="Date of Event" class="form-control" id="Date of Event" placeholder="(example- 25/05/2025)" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        
        <button type="Generate Certificate" class="btn btn-primary" style="display: block; width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Generate Certificate</button>
    </form>
        </section>


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

    <script src="../assets/js/main.js"></script>
</body>

</html>