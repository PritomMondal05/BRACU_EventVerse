<?php
$page_title = "BRACU Eventverse | Admin Dashboard";
include "../partials/header.php";
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
      font-family: 'Inter', sans-serif;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include("../partials/admin_sidebar.php")?>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h1 class="text-center"><strong>ADMIN PORTAL</strong></h1>
            <h2>Budget Request 📃</h2>
            <p>Review all details and give your decision!</p>
            
            <div class="accordion" id="accordionExample">
                <?php
                include '../config/database.php';

                $sql = "SELECT * FROM events";
                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)){
                    $sql2 = "SELECT * FROM budget WHERE event_id = '{$row['id']}' LIMIT 1";
                    $res2 = mysqli_query($conn, $sql2);
                    $budget = mysqli_fetch_assoc($res2);
                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed d-block text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne'.$row['id'].'" aria-expanded="true" aria-controls="collapseOne'.$row['id'].'">
                                <div>
                                    <p class="mb-1"><strong>Club:</strong> '.$row['club_name'].'</p>
                                    <h3 class="mb-1"><strong>Event:</strong> '.$row['name'].'</h3>
                                    <p class="mb-1"><strong>Date:</strong> '.$row['date'].'</p>
                                    <p class="mb-1"><strong>Time:</strong> '.$row['time_slot'].'</p>
                                    <p class="mb-1"><strong>Budget:</strong> '.$budget['total_budget'].' Tk</p>
                                    <p class="mb-0"><strong>Status:</strong> '.$budget['status'].'</p>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseOne'.$row['id'].'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <h5>Event Details</h5>
                                    <p><strong>Description:</strong> '.$row['details'].'</p>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item Category</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                    
                    $sql_items = "SELECT * FROM budget_items WHERE event_id = '{$row['id']}'";
                    $res_items = mysqli_query($conn, $sql_items);
                    while($item = mysqli_fetch_assoc($res_items)){
                        echo '<tr>
                            <td>'.$item['item_catagory'].'</td>
                            <td>'.$item['quantity'].'</td>
                            <td>'.$item['unit_price'].' Tk</td>
                            <td>'.$item['unit_price']*$item['quantity'].' Tk</td>
                        </tr>';
                    }

                    echo '</tbody>
                                </table>
                                <a href="./event_status.php?event_id='.$row['id'].'&status=approved"><button type="button" class="btn btn-success">Approve</button></a>
                                <a href="./event_status.php?event_id='.$row['id'].'&status=pending"><button type="button" class="btn btn-warning">Put in Hold</button></a>
                                <a href="./event_status.php?event_id='.$row['id'].'&status=deleted" onclick="return confirm(\'Are you sure you want to delete this event?\')"><button type="button" class="btn btn-danger">Delete</button></a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>