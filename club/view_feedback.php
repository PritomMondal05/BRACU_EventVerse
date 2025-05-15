<?php
$page_title = "View Feedback | Club Dashboard";
include '../config/database.php';
include "../partials/header.php";
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='club_admin'){
    header("Location: ../");
    exit();
}

// Get club information
$sql = "SELECT * FROM clubs WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$club = $stmt->get_result()->fetch_assoc();

if (!$club) {
    header("Location: ../");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Feedback - <?php echo htmlspecialchars($club['name']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    .feedback-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin: 2rem 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .feedback-item {
        background: #f8f9fa;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 10px;
        border-left: 4px solid #6C2BD9;
    }
    .feedback-meta {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.8rem;
    }
    .feedback-content {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .section-title {
        color: #6C2BD9;
        margin-bottom: 1.5rem;
        font-weight: bold;
    }
    .club-header {
        background: linear-gradient(135deg, #140A25 0%, #2C1654 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
</style>
<body>
    <?php include '../partials/club_navbar.php'; ?>

    <div class="container py-5">
        <div class="club-header">
            <h1 class="mb-3"><?php echo htmlspecialchars($club['name']); ?> - Feedback</h1>
            <p class="lead mb-0">View feedback from students about your club's events and activities</p>
        </div>

        <div class="feedback-container">
            <?php
            // Get all feedback for this club with user information
            $sql = "SELECT cf.*, u.name as student_name, u.student_id, 
                    DATE_FORMAT(cf.created_at, '%d %M %Y at %h:%i %p') as formatted_date 
                    FROM club_feedback cf 
                    JOIN users u ON cf.user_id = u.id 
                    WHERE cf.club_id = ? 
                    ORDER BY cf.created_at DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $club['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($feedback = $result->fetch_assoc()) {
                    echo '<div class="feedback-item">
                            <div class="feedback-meta">
                                <strong>Student:</strong> ' . htmlspecialchars($feedback['student_name']) . ' (' . htmlspecialchars($feedback['student_id']) . ')<br>
                                <strong>Submitted:</strong> ' . $feedback['formatted_date'] . '
                            </div>
                            <div class="feedback-content">
                                ' . htmlspecialchars($feedback['message']) . '
                            </div>
                        </div>';
                }
            } else {
                echo '<div class="alert alert-info">No feedback has been submitted for your club yet.</div>';
            }
            ?>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html> 