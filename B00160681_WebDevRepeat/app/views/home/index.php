<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- welcome section -->
<div class="container py-5">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Welcome to Appointment System</h1>
            <p class="col-md-8 fs-4">A simple and efficient way to manage your appointments.</p>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=login" class="btn btn-primary btn-lg">Login to Start</a>
                <a href="index.php?page=register" class="btn btn-outline-primary btn-lg ms-2">Register</a>
            <?php else: ?>
                <a href="index.php?page=appointments" class="btn btn-primary btn-lg">View My Appointments</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
