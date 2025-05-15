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
      <h2>Club Profile 😎</h2>
      <p>Customize your club information</p>

     <?php
include '../config/database.php';

$sql3 = "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1";
$result3 = mysqli_query($conn, $sql3);
$club = mysqli_fetch_assoc($result3);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadOk = 1;
    $target_file = $club['logo_url']; // Default to current logo
    
    // Handle logo upload if a file was selected
    if (!empty($_FILES["club_logo"]["name"])) {
        $target_dir = "uploads/";
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $imageFileType = strtolower(pathinfo($_FILES["club_logo"]["name"], PATHINFO_EXTENSION));
        $random_filename = uniqid("club_logo_", true) . "." . $imageFileType;
        $target_file = $target_dir . $random_filename;
        
        // Check if image file is a actual image or false image
        $check = getimagesize($_FILES["club_logo"]["tmp_name"]);
        if ($check === false) {
            echo '<div class="alert alert-danger">File is not an image.</div>';
            $uploadOk = 0;
        }
        
        // Check file size (5MB max)
        if ($_FILES["club_logo"]["size"] > 5000000) {
            echo '<div class="alert alert-danger">Sorry, your file is too large. Maximum size is 5MB.</div>';
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo '<div class="alert alert-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }
        
        // If everything is ok, try to upload file
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["club_logo"]["tmp_name"], $target_file)) {
                // Delete old logo if it exists and is not the default
                if (!empty($club['logo_url']) && file_exists($club['logo_url']) && $club['logo_url'] != 'uploads/default.jpg') {
                    unlink($club['logo_url']);
                }
            } else {
                echo '<div class="alert alert-danger">Sorry, there was an error uploading your file.</div>';
                $target_file = $club['logo_url']; // Keep old logo if upload fails
                $uploadOk = 0;
            }
        }
    }

    if ($uploadOk) {
        // Get form data
        $club_name = mysqli_real_escape_string($conn, $_POST['club_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $club_type = mysqli_real_escape_string($conn, $_POST['club_type']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
        $youtube = mysqli_real_escape_string($conn, $_POST['youtube']);
        $website = mysqli_real_escape_string($conn, $_POST['website']);
        $advisor = mysqli_real_escape_string($conn, $_POST['advisor']);
        $founded_date = mysqli_real_escape_string($conn, $_POST['founded_date']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $total_member = mysqli_real_escape_string($conn, $_POST['total_members']);

        // Update club information using prepared statement
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
            $club['id']
        );

        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Club information updated successfully!</div>';
            // Refresh club data
            $result3 = mysqli_query($conn, "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1");
            $club = mysqli_fetch_assoc($result3);
        } else {
            echo '<div class="alert alert-danger">Error updating club information: ' . $conn->error . '</div>';
        }
        
        $stmt->close();
    }
}
?>

      <div class="card">
        <?php if (!empty($club['logo_url'])): ?>
            <img class="w-25 border rounded shadow mx-3 my-3" src="<?php echo htmlspecialchars($club['logo_url']); ?>" alt="Club Logo">
        <?php endif; ?>
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="club_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="club_name" name="club_name" value="<?php echo htmlspecialchars($club['name']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($club['description']); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="club_type" class="form-label">Club Type</label>
                        <select class="form-select" id="club_type" name="club_type" required>
                            <option value="Academic" <?php echo $club['club_type'] == 'Academic' ? 'selected' : ''; ?>>Academic</option>
                            <option value="Cultural" <?php echo $club['club_type'] == 'Cultural' ? 'selected' : ''; ?>>Cultural</option>
                            <option value="Sports" <?php echo $club['club_type'] == 'Sports' ? 'selected' : ''; ?>>Sports</option>
                            <option value="Social" <?php echo $club['club_type'] == 'Social' ? 'selected' : ''; ?>>Social</option>
                            <option value="Technical" <?php echo $club['club_type'] == 'Technical' ? 'selected' : ''; ?>>Technical</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="club_logo" class="form-label">Club Logo</label>
                        <input type="file" class="form-control" id="club_logo" name="club_logo" accept="image/*">
                        <small class="text-muted">Max file size: 5MB. Allowed formats: JPG, JPEG, PNG, GIF</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($club['phone_number']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="url" class="form-control" id="facebook" name="facebook" value="<?php echo htmlspecialchars($club['facebook']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="youtube" class="form-label">YouTube</label>
                        <input type="url" class="form-control" id="youtube" name="youtube" value="<?php echo htmlspecialchars($club['youtube']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="<?php echo htmlspecialchars($club['website']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="advisor" class="form-label">Advisor</label>
                        <input type="text" class="form-control" id="advisor" name="advisor" value="<?php echo htmlspecialchars($club['advisor']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="founded_date" class="form-label">Founded Date</label>
                        <input type="date" class="form-control" id="founded_date" name="founded_date" value="<?php echo htmlspecialchars($club['founded_date']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($club['email']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="total_members" class="form-label">Total Members</label>
                        <input type="number" class="form-control" id="total_members" name="total_members" value="<?php echo htmlspecialchars($club['total_member']); ?>" min="0">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Details</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>

