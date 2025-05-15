<?php
$page_title = "View Feedback | Admin Dashboard";
include '../config/database.php';
include "../partials/header.php";
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='super_admin'){
    header("Location: ../");
    exit();
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
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">All Feedback</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Feedback</th>
                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM feedback ORDER BY created_at DESC";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $status_class = ($row['status'] == 'pending') ? 'warning' : 'success';
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                    <?php echo ucfirst($row['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] == 'pending') { ?>
                                                    <button class="btn btn-sm btn-success mark-reviewed" data-id="<?php echo $row['id']; ?>">
                                                        Mark as Reviewed
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No feedback found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.mark-reviewed').forEach(button => {
    button.addEventListener('click', function() {
        const feedbackId = this.getAttribute('data-id');
        if (confirm('Mark this feedback as reviewed?')) {
            fetch('../sql/update_feedback_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${feedbackId}&status=reviewed`
            })
            .then(response => response.text())
            .then(result => {
                if (result === 'success') {
                    location.reload();
                } else {
                    alert('Error updating status');
                }
            });
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>
