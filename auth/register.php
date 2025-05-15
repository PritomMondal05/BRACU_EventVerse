<?php
$page_title = "BRACU Eventverse | Auth";
include "../partials/header.php"; // header.php can access $page_title
?>
<section class="bg-light d-flex justify-content-center align-items-center vh-100">
    

    <div class="card shadow p-4 mx-3" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Register</h4>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter your name">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Role</label>
                <select class="form-select" name="role" aria-label="Default select example">
                    <option value="student">Student</option>
                    <option value="club_admin">Club Admin</option>
                    <!-- <option value="dept_admin">Department Admin</option>
                    <option value="super_admin">Super Admin</option> -->
                  </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <a class="text-center my-2" href="../">Already have a account</a>
    </div>
</section>

<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email     = $_POST['email'];
    $role      = $_POST['role'];
    $password  = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $sql = "INSERT INTO users (name, email, role, password)
            VALUES ('$user_name', '$email', '$role', '$hashedPassword')";
    $res = mysqli_query($conn, $sql);

    $sql3 = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result3 = mysqli_query($conn, $sql3);
    $user = mysqli_fetch_assoc($result3);

    if($role=='club_admin'){
        $sql2 = "INSERT INTO clubs (name, admin_id)
            VALUES ('$user_name', '{$user['id']}')";
    $res2 = mysqli_query($conn, $sql2);
    }


    if ($res) {
        echo "User saved successfully!";
        header("Location: ../");
    } else {
        echo "Failed to save user.";
    }

}

?>