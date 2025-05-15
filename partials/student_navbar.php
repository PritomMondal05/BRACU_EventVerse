<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="../">BRACU<span class="text-primary">eventverse</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./clubs.php">Clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./register_event.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./certificates.php">Certificates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">About</a>
                </li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="./profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sql/logout.php">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 