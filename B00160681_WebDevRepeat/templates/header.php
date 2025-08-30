<?php
// session starts in index.php
?>
<!DOCTYPE html>
<html>
<head>
    <!-- basic page setup -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- load bootstrap and custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <!-- site title -->
            <a class="navbar-brand" href="/B00160681_WebDevRepeat/index.php">Appointment System</a>
            <!-- mobile menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- menu items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- always visible links -->
                    <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php?page=about">About</a></li>
                    <!-- show these links when logged in -->
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php?page=appointments">Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php?page=logout">Logout</a></li>
                    <!-- show these links when logged out -->
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php?page=login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="/B00160681_WebDevRepeat/index.php?page=register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <!-- show alert messages if any -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info'; ?> mt-4">
                <?php 
                    // display and clear message
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>
