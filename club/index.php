<?php
$page_title = "BRACU Eventverse | Club Dashboard";
include "../partials/header.php"; // header.php can access $page_title
session_start();
if($_SESSION['role']!=='club_admin'){
    header("Location: ../");
}

// Get club information early
include '../config/database.php';
$sql3 = "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1";
$result3 = mysqli_query($conn, $sql3);
$club = mysqli_fetch_assoc($result3);
?>

<style>
    body {
      min-height: 100vh;
    }
    .sidebar {
      height: 100vh;
      background-color: #f8f9fa;
      box-shadow: 4px 0px 7px -7px; 
      border-radius: 10px;
    }
    .sidebar a {
      display: block;
      padding: 15px;
      color: #000;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #6C2BD9;
      color: white;
      border-radius: 10px;
    }
    h3{
        color: #6C2BD9;
        font-family: 'Inter', sans-serif;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #6C2BD9, #8B5CF6);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .welcome-banner h1 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: bold;
    }
    .welcome-banner p {
        margin: 0.5rem 0 0;
        font-size: 1.1rem;
        opacity: 0.9;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/club_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <div class="welcome-banner">
        <h1>Welcome to <?php echo htmlspecialchars($club['name']); ?> Portal 👋</h1>
        <p>Manage your events and create amazing experiences for the BRACU community</p>
      </div>

      <h2>My Events</h2>
      <p>Your club is going to organize these events</p>

      <div class="row">
        <?php
        $sql = "SELECT * FROM events WHERE club_id = '{$club['id']}'";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
          echo "
          <div class='col-md-4 mb-4'>
              <div class='card h-100'>
                  <img src='" . htmlspecialchars($row['thumbnail'] ?? 'default.jpg') . "' class='card-img-top' alt='Card image'>
                  <div class='card-body'>
                      <h3>" . htmlspecialchars($row['name']) . "</h3>
                      <p class='card-text'><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>
                      <p class='card-text'><strong>Time Slot:</strong> " . htmlspecialchars($row['time_slot']) . "</p>
                      <p class='card-text'><strong>Details:</strong> " . nl2br(htmlspecialchars($row['details'])) . "</p>
                      <p class='card-text'><strong>Location:</strong> " . nl2br(htmlspecialchars($row['room_no'])) . "</p>
                      " . (
                          $row['status'] == 'pending' ? "<span class='badge text-bg-warning'>PENDING</span>" :
                          ($row['status'] == 'approved' ? "<span class='badge text-bg-success'>APPROVED</span>" :
                          "<span class='badge text-bg-danger'>CANCELED</span>")
                      ) . "
                  </div>
              </div>
          </div>
          ";
        }
        ?>
      </div>
    </div>
  </div>
</div>