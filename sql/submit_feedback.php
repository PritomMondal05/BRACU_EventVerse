<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    $_SESSION['error_message'] = "You must be logged in as a student to submit feedback.";
    header("Location: ../student/feedback.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Thank you for your feedback!');
            window.location.href = '../student/about.php';
        </script>";
    } else {
        echo "<script>
            alert('Error submitting feedback. Please try again.');
            window.location.href = '../student/about.php';
        </script>";
    }
} else {
    header("Location: ../student/about.php");
    exit();
}
?> 