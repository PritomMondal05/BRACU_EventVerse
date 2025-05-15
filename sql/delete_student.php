<?php
include '../config/database.php';
session_start();

if ($_SESSION['role'] === 'super_admin' && isset($_GET['id'])) {
    $student_id = $_GET['id'];
    
    // First, delete any event registrations
    $sql1 = "DELETE FROM event_registrations WHERE user_id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $student_id);
    $stmt1->execute();
    
    // Then delete the user
    $sql2 = "DELETE FROM users WHERE id = ? AND role = 'student'";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $student_id);
    
    if ($stmt2->execute()) {
        header("Location: ../admin/all_students.php?success=2");
    } else {
        header("Location: ../admin/all_students.php?error=2");
    }
    
    $stmt1->close();
    $stmt2->close();
} else {
    header("Location: ../");
}
?> 