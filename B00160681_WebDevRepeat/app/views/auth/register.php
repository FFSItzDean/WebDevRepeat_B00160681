<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- main register page content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- signup form -->
            <form action="/B00160681_WebDevRepeat/index.php?page=register" method="post" name="Register_Form" class="mt-4">
                <h2 class="text-center mb-4">Register</h2>
                <!-- username field -->
                <div class="mb-3">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input name="username" type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                </div>
                <!-- email field -->
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required>
                </div>
                <!-- full name field -->
                <div class="mb-3">
                    <label for="inputFullName" class="form-label">Full Name</label>
                    <input name="full_name" type="text" id="inputFullName" class="form-control" placeholder="Full Name" required>
                </div>
                <!-- password field -->
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                </div>
                <button name="Submit" value="Register" class="btn btn-primary w-100" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
