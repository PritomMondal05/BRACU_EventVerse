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

        <section class="popular-events py-5 bg-dark text-light">
            <div class="container">
              <h2 class="mb-4 text-white text-uppercase">All Clubs</h2>
              <div class="row">
                <?php
                $sql = "SELECT * FROM clubs";
    $res = mysqli_query($conn, $sql);
    while($row=mysqli_fetch_assoc($res)){
        echo '
<div class="col-md-6 col-lg-3 mb-4">
  <div class="card h-100 shadow text-center position-relative" style="background-color: #140A25; color: #fff; border-radius: 20px;">
  
    <!-- Event Type Badge -->
    <span class="position-absolute top-0 end-0 m-2 badge bg-dark text-uppercase" style="z-index: 1;">
      '.$row['club_type'].'
    </span>

    <img src="../club/'.$row['logo_url'].'" class="card-img-top rounded-top" alt="Club Image" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
    
    <div class="card-body d-flex flex-column">
      <h5 class="card-title text-white fw-bold">'.$row['name'].'</h5>
      
      <p class="card-text mt-2 text-light">
        '.substr(strip_tags($row['description']), 0, 100).'...
      </p>
      <a href="#" class="btn mt-auto" style="background-color: #883FEB; color: white;">Learn More</a>
    </div>
  </div>
</div>
';

    }
                ?>
                
          
                <!-- Repeat card for more events -->
              </div>
          
              <!-- <div class="text-center mt-4">
                <button class="btn btn-outline-light">View More</button>
              </div> -->
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
            <p>&copy; 2025 BRACU Eventverse. All rights reserved.</p>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>

</html>