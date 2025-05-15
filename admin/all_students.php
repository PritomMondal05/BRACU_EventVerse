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
    .btn-edit {
        background-color: #FFC107;
        color: white;
    }
    .btn-delete {
        background-color: #DC3545;
        color: white;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/admin_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h1 class="text-center"><strong>ADMIN PORTAL</strong></h1>
      <h2>All Students 👤</h2>
      <p>All Students list</p>
      <div class="container my-5">
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Joining Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include '../config/database.php';

        $sql = "SELECT id, name, email, created_at FROM users WHERE role = 'student'";
        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            echo '
              <tr>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['email']) . '</td>
                <td>' . date("F j, Y", strtotime($row['created_at'])) . '</td>
                <td>
                  <button type="button" class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#editModal' . $row['id'] . '">
                    Edit
                  </button>
                  <a href="../sql/delete_student.php?id=' . $row['id'] . '" class="btn btn-delete btn-sm" onclick="return confirm(\'Are you sure you want to delete this student?\')">
                    Delete
                  </a>
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel">Edit Student Information</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../sql/edit_student.php" method="POST">
                      <div class="modal-body">
                        <input type="hidden" name="student_id" value="' . $row['id'] . '">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="' . htmlspecialchars($row['name']) . '" required>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input type="email" class="form-control" id="email" name="email" value="' . htmlspecialchars($row['email']) . '" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            ';
          }
        } else {
          echo '<tr><td colspan="4" class="text-center">No students found.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>


      
  
     
    </div>
  </div>
</div>