<?php
$page_title = "BRACU Eventverse | Club Dashboard";
include "../partials/header.php"; // header.php can access $page_title
session_start();
if($_SESSION['role']!=='super_admin'){
    header("Location: ../");
}
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
    .table_head{
      color: #6C2BD9 !important;
        font-family: 'Inter', sans-serif;
    }
    h3{
        color: #6C2BD9;
        font-family: 'Inter', sans-serif;;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/admin_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h1 class="text-center"><strong>ADMIN PORTAL</strong></h1>
      <h2>All Clubs 🏢</h2>
      <p>List of All clubs in BRACU EventVerse</p>
      <div class="container my-5">
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <?php
    include '../config/database.php';

    $sql = "SELECT * FROM clubs";
    $res = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($res)) {
      echo '
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="../club/' . $row['logo_url'] . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
          <div class="card-body">
            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
            <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
          </div>
          <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
              <small class="text-muted">' . htmlspecialchars($row['club_type']) . '</small>
              <a href="edit_club.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Edit Club</a>
            </div>
            <small class="text-muted d-block mt-2">' . date('F j, Y', strtotime($row['founded_date'])) . '</small>
          </div>
        </div>
      </div>
      ';
    }
    ?>
  </div>
</div>

      
  
     
    </div>
  </div>
</div>