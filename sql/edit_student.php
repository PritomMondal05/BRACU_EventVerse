<?php
include '../config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role'] === 'super_admin') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Update student information
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ? AND role = 'student'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $student_id);
    
    if ($stmt->execute()) {
        header("Location: ../admin/all_students.php?success=1");
    } else {
        header("Location: ../admin/all_students.php?error=1");
    }
    
    $stmt->close();
} else {
    header("Location: ../");
}
?> 