<?php
$page_title = "BRACU Eventverse | Club Dashboard";
include "../partials/header.php"; // header.php can access $page_title
session_start();
if($_SESSION['role']!=='club_admin'){
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
    h3{
        color: #6C2BD9;
        font-family: 'Times New Roman', Times, serif;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar">
      <h3 class="p-3">BRACU EventVerse</h3>
      <a href="#">My Events</a>
      <a href="#">Create Event</a>
      <a href="#">Budget Requests</a>
      <a href="#">Submit a Budget</a>
    </div>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2>My Events</h2>
      <p>Your club is going to organize these events</p>
    </div>
  </div>
</div>