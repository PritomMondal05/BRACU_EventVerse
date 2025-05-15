<?php
$page_title = "BRACU Eventverse | Auth";
include "partials/header.php"; // header.php can access $page_title
?>
<section class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Login</h4>
        <form method="POST" action="./sql/login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <a class="text-center my-2" href="./auth/register.php">Don't have a account</a>
    </div>

    
</section>

