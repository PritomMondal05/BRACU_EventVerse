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
        font-family: 'Inter', sans-serif;
    }
  </style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/club_sidebar.php")?>


    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2>Add Items Budget 💲</h2>
      <p>Add items budget that is required for your event</p>

      <?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $item_category = $_POST['item_category'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $total_price = $unit_price*$quantity;

    $sql3 = "SELECT * FROM budget WHERE event_id = '$event_id' LIMIT 1";
    $result3 = mysqli_query($conn, $sql3);
    $budget = mysqli_fetch_assoc($result3);

    // Insert into buget_items table
    $sql = "INSERT INTO budget_items (event_id, budget_id, quantity, unit_price, total_price, item_catagory)
        VALUES ('$event_id', '{$budget['id']}', '$quantity', '$unit_price', '$total_price', '$item_category')";

    $res = mysqli_query($conn, $sql);

    // Update total budget
    $sql = "UPDATE `budget` SET `total_budget` = `total_budget` + $total_price WHERE `id` = {$budget['id']}";
    $res = mysqli_query($conn, $sql);

    

    if ($res) {
        echo '
        <div class="alert alert-success" role="alert">
  Item added to Budget
</div>
        ';
    } else {
      echo '
      <div class="alert alert-danger" role="alert">
Something went wrong!
</div>
      ';
    }

}

?>

      <div class="card">
  <div class="card-body">
    <form method="POST" action="">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Select Event</label>
          <select class="form-select" name="event_id" aria-label="Default select example">
          <?php
    include '../config/database.php';
    $sql3 = "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1";
    $result3 = mysqli_query($conn, $sql3);
    $club = mysqli_fetch_assoc($result3);

    $sql = "SELECT * FROM events WHERE club_id = '{$club['id']}'";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        
        echo '
            <option value="'.$row['id'].'">'.$row['name'].'</option>
        ';
    }
    ?>
    </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Item Catagory</label>
          <input type="text" class="form-control" name="item_category">
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Quantity</label>
          <input type="number" class="form-control" name="quantity">
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Unit Price</label>
          <input type="number" class="form-control" name="unit_price">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

    </div>
  </div>
</div>

