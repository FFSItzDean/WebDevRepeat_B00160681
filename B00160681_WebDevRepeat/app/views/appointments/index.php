<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- page title and create button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Appointments</h2>
    <div>
        <a href="index.php?page=appointments&action=create" class="btn btn-primary">Create New Appointment</a>
    </div>
</div>

<!-- search box -->
<div class="card mb-4">
    <div class="card-body">
        <form action="index.php" method="GET" class="row g-3">
            <!-- hidden fields for routing -->
            <input type="hidden" name="page" value="appointments">
            <input type="hidden" name="action" value="search">
            <!-- search input -->
            <div class="col-auto flex-grow-1">
                <input type="text" name="search" class="form-control" placeholder="Search appointments...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>
    </div>
</div>

<!-- appointments list table -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- show appointments if any exist -->
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <!-- show appointment details safely -->
                        <td><?php echo htmlspecialchars($appointment['title']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                        <!-- status badge with color -->
                        <td>
                            <span class="badge bg-<?php echo $appointment['status'] === 'completed' ? 'success' : 
                                ($appointment['status'] === 'cancelled' ? 'danger' : 'warning'); ?>">
                                <?php echo ucfirst(htmlspecialchars($appointment['status'])); ?>
                            </span>
                        </td>
                        <!-- edit and delete buttons -->
                        <td>
                            <a href="index.php?page=appointments&action=edit&id=<?php echo $appointment['id']; ?>" 
                               class="btn btn-sm btn-primary">Edit</a>
                            <a href="index.php?page=appointments&action=delete&id=<?php echo $appointment['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No appointments found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
