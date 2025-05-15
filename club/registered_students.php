<?php
$page_title = "BRACU Eventverse | Registered Students";
include "../partials/header.php";
session_start();
if($_SESSION['role']!=='club_admin'){
    header("Location: ../");
}

// Get club information
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
    .event-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        padding: 20px;
    }
    .student-list {
        margin-top: 15px;
    }
    .student-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .student-item:last-child {
        border-bottom: none;
    }
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/club_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2>Registered Students 👥</h2>
      <p>View all students registered for your club's events</p>

      <?php
      // Get all events for this club with their registered students
      $sql = "SELECT e.*, COUNT(er.user_id) as registered_count 
              FROM events e 
              LEFT JOIN event_registrations er ON e.id = er.event_id 
              WHERE e.club_id = ? 
              GROUP BY e.id 
              ORDER BY e.date DESC";
      
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $club['id']);
      $stmt->execute();
      $events_result = $stmt->get_result();

      if ($events_result->num_rows > 0) {
          while ($event = $events_result->fetch_assoc()) {
              echo '<div class="event-card">';
              echo '<h3>' . htmlspecialchars($event['name']) . '</h3>';
              echo '<p><strong>Date:</strong> ' . htmlspecialchars($event['date']) . '</p>';
              echo '<p><strong>Time:</strong> ' . htmlspecialchars($event['time_slot']) . '</p>';
              echo '<p><strong>Registered Students:</strong> ' . $event['registered_count'] . '</p>';
              
              // Get registered students for this event
              $sql2 = "SELECT u.* FROM users u 
                       INNER JOIN event_registrations er ON u.id = er.user_id 
                       WHERE er.event_id = ?";
              $stmt2 = $conn->prepare($sql2);
              $stmt2->bind_param("i", $event['id']);
              $stmt2->execute();
              $students_result = $stmt2->get_result();

              if ($students_result->num_rows > 0) {
                  echo '<div class="student-list">';
                  echo '<h5>Student Details:</h5>';
                  echo '<div class="table-responsive">';
                  echo '<table class="table table-hover">';
                  echo '<thead><tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Registration Date</th>
                        </tr></thead>';
                  echo '<tbody>';
                  
                  while ($student = $students_result->fetch_assoc()) {
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($student['user_name']) . '</td>';
                      echo '<td>' . htmlspecialchars($student['email']) . '</td>';
                      
                      // Get registration date
                      $sql3 = "SELECT created_at FROM event_registrations 
                              WHERE event_id = ? AND user_id = ?";
                      $stmt3 = $conn->prepare($sql3);
                      $stmt3->bind_param("ii", $event['id'], $student['id']);
                      $stmt3->execute();
                      $reg_date = $stmt3->get_result()->fetch_assoc();
                      
                      echo '<td>' . htmlspecialchars($reg_date['created_at'] ?? 'N/A') . '</td>';
                      echo '</tr>';
                  }
                  
                  echo '</tbody></table>';
                  echo '</div>'; // table-responsive
                  echo '</div>'; // student-list
              } else {
                  echo '<p class="text-muted">No students registered yet.</p>';
              }
              
              echo '</div>'; // event-card
          }
      } else {
          echo '<div class="alert alert-info">No events found for your club.</div>';
      }
      ?>

    </div>
  </div>
</div> 