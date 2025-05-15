<?php
include '../config/database.php';

// Create simplified feedback table
$sql = "CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'reviewed') DEFAULT 'pending'
)";

if (mysqli_query($conn, $sql)) {
    echo "Feedback table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?> 