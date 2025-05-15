<?php
include '../config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "Please login first";
        exit;
    }
    
    // Check if already registered
    $check_sql = "SELECT * FROM event_registrations WHERE event_id = '$event_id' AND user_id = '$user_id'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "You have already registered for this event";
        exit;
    }
    
    // Register for the event
    $sql = "INSERT INTO event_registrations (event_id, user_id) 
            VALUES ('$event_id', '$user_id')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../student/register_event.php");
    } else {
        echo "Error registering for event: " . mysqli_error($conn);
    }
}
?> 