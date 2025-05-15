<?php
$page_title = "BRACU Eventverse | Edit Club";
include "../partials/header.php";
session_start();
if($_SESSION['role']!=='super_admin'){
    header("Location: ../");
}

include '../config/database.php';

// Get club information if ID is provided
if (isset($_GET['id'])) {
    $club_id = $_GET['id'];
    $sql = "SELECT * FROM clubs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $club = $stmt->get_result()->fetch_assoc();

    if (!$club) {
        header("Location: ./all_clubs.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club_id = $_POST['club_id'];
    $club_name = $_POST['club_name'];
    $description = $_POST['description'];
    $club_type = $_POST['club_type'];
    $phone_number = $_POST['phone_number'];
    $facebook = $_POST['facebook'];
    $youtube = $_POST['youtube'];
    $website = $_POST['website'];
    $advisor = $_POST['advisor'];
    $founded_date = $_POST['founded_date'];
    $email = $_POST['email'];
    $total_member = $_POST['total_members'];

    $target_file = $club['logo_url']; // Default to current logo

    // Handle logo upload if provided
    if (!empty($_FILES["club_logo"]["tmp_name"])) {
        $target_dir = "../club/uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["club_logo"]["name"], PATHINFO_EXTENSION));
        $random_filename = uniqid("club_logo_", true) . "." . $imageFileType;
        $target_file = "uploads/" . $random_filename;

        // Check if image file is valid
        $check = getimagesize($_FILES["club_logo"]["tmp_name"]);
        if ($check !== false && move_uploaded_file($_FILES["club_logo"]["tmp_name"], "../club/" . $target_file)) {
            // File uploaded successfully
        } else {
            $target_file = $club['logo_url']; // Keep old logo if upload fails
        }
    }

    // Update club information
    $sql = "UPDATE clubs SET 
        name = ?, 
        description = ?, 
        club_type = ?, 
        logo_url = ?, 
        phone_number = ?, 
        facebook = ?, 
        youtube = ?, 
        website = ?, 
        advisor = ?, 
        founded_date = ?, 
        email = ?, 
        total_member = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssii", 
        $club_name, 
        $description, 
        $club_type, 
        $target_file,
        $phone_number,
        $facebook,
        $youtube,
        $website,
        $advisor,
        $founded_date,
        $email,
        $total_member,
        $club_id
    );

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Club information updated successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating club information.</div>';
    }
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
        <?php include("../partials/admin_sidebar.php")?>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2>Edit Club Information 🏢</h2>
            <p>Update club details and information</p>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="club_id" value="<?php echo $club['id']; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Current Logo</label>
                                <img src="../club/<?php echo $club['logo_url']; ?>" class="img-fluid mb-2 rounded" style="max-width: 200px;">
                                <input type="file" class="form-control" name="club_logo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Club Name</label>
                                <input type="text" class="form-control" name="club_name" value="<?php echo htmlspecialchars($club['name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($club['description']); ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Club Type</label>
                                <input type="text" class="form-control" name="club_type" value="<?php echo htmlspecialchars($club['club_type']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" value="<?php echo htmlspecialchars($club['phone_number']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="facebook" value="<?php echo htmlspecialchars($club['facebook']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="text" class="form-control" name="youtube" value="<?php echo htmlspecialchars($club['youtube']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website</label>
                                <input type="text" class="form-control" name="website" value="<?php echo htmlspecialchars($club['website']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Advisor</label>
                                <input type="text" class="form-control" name="advisor" value="<?php echo htmlspecialchars($club['advisor']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Founded Date</label>
                                <input type="date" class="form-control" name="founded_date" value="<?php echo htmlspecialchars($club['founded_date']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($club['email']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Members</label>
                                <input type="number" class="form-control" name="total_members" value="<?php echo htmlspecialchars($club['total_member']); ?>">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Club Information</button>
                            <a href="./all_clubs.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 