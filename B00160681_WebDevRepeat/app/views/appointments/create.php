<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- create appointment form -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Create New Appointment</div>
            <div class="card-body">
                <!-- form posts to create action -->
                <form method="POST" action="index.php?page=appointments&action=create">
                    <!-- appointment title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <!-- optional description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <!-- appointment date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <!-- appointment time -->
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <!-- form buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Appointment</button>
                        <a href="index.php?page=appointments" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
