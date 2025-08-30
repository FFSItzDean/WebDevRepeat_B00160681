<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- edit appointment form -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Appointment</div>
            <div class="card-body">
                <!-- form posts to edit action with appointment id -->
                <form method="POST" action="index.php?page=appointments&action=edit&id=<?php echo $appointment['id']; ?>">
                    <!-- appointment title with current value -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($appointment['title']); ?>" required>
                    </div>
                    <!-- optional description with current text -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                        ><?php echo htmlspecialchars($appointment['description']); ?></textarea>
                    </div>
                    <!-- appointment date with current value -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" 
                               value="<?php echo $appointment['appointment_date']; ?>" required>
                    </div>
                    <!-- appointment time with current value -->
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" 
                               value="<?php echo $appointment['appointment_time']; ?>" required>
                    </div>
                    <!-- status dropdown with current selection -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="pending" <?php echo $appointment['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="completed" <?php echo $appointment['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $appointment['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <!-- form buttons -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                        <a href="index.php?page=appointments" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
