<?php
$page_title="BRACU Eventverse - Your University Event Hub";
require_once '../config/database.php';
include "../partials/header.php";
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='student'){
    header("Location: ../");
}
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

    <main>
        <section class="hero">
            <h1><strong>Don't miss out!</strong></h1>
            <p>Dive into the vibrant world of BRACU events and get involved!</p>
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

        <section class="students-welocome">
            <div style="text-align: center;">
                <div style="height: 50px;"></div>
                <h2>Welcome <strong>Students!</strong></h2>
            </div>
        </section>

        <section class="popular-events py-5">
            <div id="events_section" class="container">
                <h2 class="mb-4">Upcoming Events</h2>
                <div class="row">
                    <?php
                    // Get the category type from the URL and sanitize it
                    $type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';

                    // Modify the SQL query to filter by category if a type is provided
                    if (!empty($type)) {
                        $sql = "SELECT e.*, c.name as club_name FROM events e 
                               LEFT JOIN clubs c ON e.club_id = c.id 
                               WHERE e.status = 'approved' AND e.event_type = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $type);
                    } else {
                        $sql = "SELECT e.*, c.name as club_name FROM events e 
                               LEFT JOIN clubs c ON e.club_id = c.id 
                               WHERE e.status = 'approved'";
                        $stmt = $conn->prepare($sql);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are events to display
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Debug information
                            echo "<!-- Debug: Event ID: " . $row['id'] . ", Status: " . $row['status'] . ", Date: " . $row['date'] . " -->";
                            
                            echo '
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow text-center position-relative" style="background-color: #140A25; color: #fff; border-radius: 20px;">
                                    <!-- Event Type Badge -->
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark text-uppercase" style="z-index: 1;">
                                        ' . htmlspecialchars($row['event_type']) . '
                                    </span>

                                    <img src="' . htmlspecialchars($row['thumbnail']) . '" class="card-img-top rounded-top" alt="Event Image" style="height: 200px; object-fit: cover; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-white fw-bold">' . htmlspecialchars($row['name']) . '</h5>
                                        <p class="card-subtitle mb-2" style="color: #883FEB;">By ' . htmlspecialchars($row['club_name']) . '</p>
                                        <p class="card-subtitle mb-2 fst-italic text-light-emphasis" style="color: #cccccc;">
                                            📅 ' . htmlspecialchars($row['date']) . '<br>
                                            ⏰ ' . htmlspecialchars($row['time_slot']) . '<br>
                                            📍 ' . htmlspecialchars($row['room_no']) . '
                                        </p>
                                        <p class="card-text mt-2 text-light">
                                            ' . htmlspecialchars(substr(strip_tags($row['details']), 0, 100)) . '...
                                        </p>
                                        <form method="POST" action="../sql/register_event.php" class="mt-auto">
                                            <input type="hidden" name="event_id" value="' . $row['id'] . '">
                                            <button type="submit" class="btn w-100" style="background-color: #883FEB; color: white;">Register Now</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    } else {
                        echo '<div class="col-12 text-center">
                                <div class="alert alert-info">
                                    No upcoming events found' . (!empty($type) ? ' for ' . htmlspecialchars($type) . ' category' : '') . '.
                                </div>
                              </div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="event-categories">
            <h2>Category</h2>
            <div class="category-grid">
                <a href="./index.php?type=technical#events_section">
                    <div class="category-card">
                        <i class="fas fa-laptop-code"></i>
                        <h3>Technical</h3>
                    </div>
                </a>
                <a href="./index.php?type=cultural#events_section">
                    <div class="category-card">
                        <i class="fas fa-music"></i>
                        <h3>Cultural</h3>
                    </div>
                </a>
                <a href="./index.php?type=academic#events_section">
                    <div class="category-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Academic</h3>
                    </div>
                </a>
                <a href="./index.php?type=social#events_section">
                    <div class="category-card">
                        <i class="fas fa-users"></i>
                        <h3>Social</h3>
                    </div>
                </a>
                <a href="./index.php?type=sports#events_section">
                    <div class="category-card">
                        <i class="fas fa-trophy"></i>
                        <h3>Sports</h3>
                    </div>
                </a>
            </div>
        </section>
    </main>

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
            <p>&copy; 2025 Pritom, Muna & Lamima-CSE370 Project: BRACU Eventverse. All rights reserved.</p>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>

</html>