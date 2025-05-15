<?php
$page_title="BRACU Eventverse - Your University Event Hub";
require_once '../config/database.php';
include "../partials/header.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch the count of registered events
$event_query = "SELECT COUNT(*) AS event_count FROM event_registrations WHERE user_id = ?";
$event_stmt = $conn->prepare($event_query);
$event_stmt->bind_param("i", $user_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
$event_data = $event_result->fetch_assoc();
$event_count = $event_data['event_count'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRACU Eventverse - Your University Event Hub</title>
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
                <?php if(isset($_SESSION['user_id'])): ?>
                <a href="./profile.php">Profile</a>
                <a href="../sql/logout.php">Logout</a>
                <?php else: ?>
                <a href="pages/login.php" class="login-btn">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    
    <main class="py-5">
        <section class="w-100 px-4 py-5" style="background-color:rgb(18, 18, 18); ">
        <h2><strong>Your Profile</strong></h2>
            <div style="height: 50px;"></div>
            <div class="row d-flex justify-content-center">
                <div class="col col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <h5 class="mb-1">Name: <?php echo htmlspecialchars($user['name']); ?></h5>
                            <p class="mb-2 pb-1">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                            <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                                <div>
                                    <p class="small text-muted mb-1">Phone</p>
                                    <p class="mb-0">+880 1791 634186</p>
                                </div>
                                <div class="px-3">
                                    <p class="small text-muted mb-1">Registered Events</p>
                                    <p class="mb-0"><?php echo $event_count; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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