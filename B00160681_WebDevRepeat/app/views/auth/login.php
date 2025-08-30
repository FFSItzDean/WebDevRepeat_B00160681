<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- main login page content -->
<div class="container py-5">
    <!-- show welcome message if not logged in -->
    <?php if(!isset($_SESSION['user_id'])): ?>
    <div class="p-5 mb-4 bg-light rounded-3 text-center">
        <div class="container-fluid py-4">
            <h1 class="display-5 fw-bold">Welcome to the Appointment System</h1>
            <p class="fs-4">A simple and efficient way to manage your appointments.</p>
        </div>
    </div>
    <?php endif; ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- login form -->
            <form action="/B00160681_WebDevRepeat/index.php?page=login" method="post" name="Login_Form" class="mt-4">
                <h2 class="text-center mb-4">Please sign in</h2>
                <!-- username field -->
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                </div>
                <!-- password field -->
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                </div>
                <!-- remember me checkbox -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" value="remember-me">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button name="Submit" value="Login" class="btn btn-primary w-100" type="submit">Sign in</button>
            </form>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
