<?php require_once dirname(__DIR__, 3) . '/templates/header.php'; ?>

<!-- search results header -->
<div class="mb-4">
    <h2>Search Results</h2>
    <!-- back button -->
    <a href="index.php?page=appointments" class="btn btn-secondary">Back to Appointments</a>
</div>

<!-- results table -->
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
            <!-- show matching appointments if found -->
            <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <!-- show appointment details safely -->
                        <td><?php echo htmlspecialchars($appointment['title']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                        <!-- status badge with color based on state -->
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
                    <td colspan="5" class="text-center">No appointments found matching your search</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__, 3) . '/templates/footer.php'; ?>
