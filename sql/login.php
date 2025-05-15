<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 0) {
        echo "User doesn't exist.";
        exit;
    }

    $user = mysqli_fetch_assoc($result);

    // Verify password
    if (!password_verify($password, $user['password'])) {
        echo "Invalid password.";
        exit;
    }

    // Set session if needed (optional)
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    switch ($user['role']) {
        case 'student':
            header("Location: ../student");
            break;
        case 'club_admin':
            header("Location: ../club");
            break;
        case 'dept_admin':
            header("Location: /department/dashboard.php");
            break;
        case 'super_admin':
            header("Location: ../admin/");
            break;
        default:
            echo "Role not recognized.";
    }

    exit;
}
?>
