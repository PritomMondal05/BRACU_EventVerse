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
    .table_head{
      color: #6C2BD9 !important;
        font-family: 'Inter', sans-serif;
    }
    h3{
        color: #6C2BD9;
        font-family: 'Inter', sans-serif;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/club_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2>Budget Items 📃</h2>
      <p>Items budget for different events</p>
      
      <div class="accordion" id="accordionExample">
      <?php
    include '../config/database.php';
    $sql3 = "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1";
    $result3 = mysqli_query($conn, $sql3);
    $club = mysqli_fetch_assoc($result3);

    $sql = "SELECT * FROM events WHERE club_id = '{$club['id']}'";
    $res = mysqli_query($conn, $sql);
    while($row=mysqli_fetch_assoc($res)){
          $sql2 = "SELECT * FROM budget WHERE event_id = '{$row['id']}' LIMIT 1";
          $res2 = mysqli_query($conn, $sql2);
          $budget=mysqli_fetch_assoc($res2);
          echo '
            <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne'.$row['id'].'" aria-expanded="true" aria-controls="collapseOne">
            '.$row['name'].' - '.$budget['total_budget'].' Tk - '.$budget['status'].'
          </button>
        </h2>
        <div id="collapseOne'.$row['id'].'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
              <table class="table">
      <thead>
        <tr>
          <th scope="col">Item Catagory</th>
          <th scope="col">Quantity</th>
          <th scope="col">Unit Price</th>
          <th scope="col">Total Price</th>
        </tr>
      </thead>
      <tbody>
          
            ';
            $sql_items = "SELECT * FROM budget_items WHERE event_id = '{$row['id']}'";
            $res_items = mysqli_query($conn, $sql_items);
            while($item = mysqli_fetch_assoc($res_items)){
          echo '
          <tr>
          <td>'.$item['item_catagory'].'</td>
          <td>'.$item['quantity'].'</td>
          <td>'.$item['unit_price'].' Tk</td>
          <td>'.$item['unit_price']*$item['quantity'].' Tk</td>
          </tr>
          ';  
        }

            echo '
            </tbody>
        </table>
            </div>
        </div>
      </div>';

    }

    
    ?>
  
</div>

   
    
   
 

      
     
    </div>
  </div>
</div>