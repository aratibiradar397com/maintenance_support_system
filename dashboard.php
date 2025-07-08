<?php
require_once '../config.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and is HOD
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hod') {
    header("Location: ../login.php");
    exit();
}

// Get all issues with error handling
try {
    $stmt = $pdo->query("
        SELECT i.*, u.username as reporter_name, t.username as technician_name 
        FROM issues i 
        LEFT JOIN users u ON i.user_id = u.id 
        LEFT JOIN users t ON i.assigned_technician_id = t.id 
        ORDER BY i.reported_at DESC
    ");
    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug information
    echo '<div class="alert alert-info">Number of issues found: ' . count($issues) . '</div>';
    
    if (count($issues) === 0) {
        // Check if there are any issues in the database
        $check_issues = $pdo->query("SELECT COUNT(*) as count FROM issues");
        $total_issues = $check_issues->fetch(PDO::FETCH_ASSOC);
        echo '<div class="alert alert-warning">Total issues in database: ' . $total_issues['count'] . '</div>';
        
        // Check if there are any users
        $check_users = $pdo->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
        $users_by_role = $check_users->fetchAll(PDO::FETCH_ASSOC);
        echo '<div class="alert alert-warning">Users by role:<br>';
        foreach ($users_by_role as $role) {
            echo $role['role'] . ': ' . $role['count'] . '<br>';
        }
        echo '</div>';
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
}

// Get technicians for assignment
$stmt = $pdo->query("SELECT id, username FROM users WHERE role = 'technician'");
$technicians = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard - Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-4">
        <h2>HOD Dashboard</h2>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h4>Pending Issues</h4>
                <p class="h2 text-warning"><?php echo count(array_filter($issues, function($i) { return $i['status'] == 'pending'; })); ?></p>
            </div>
            <div class="stat-card">
                <h4>In Progress</h4>
                <p class="h2 text-primary"><?php echo count(array_filter($issues, function($i) { return $i['status'] == 'in_progress'; })); ?></p>
            </div>
            <div class="stat-card">
                <h4>Resolved</h4>
                <p class="h2 text-success"><?php echo count(array_filter($issues, function($i) { return $i['status'] == 'resolved'; })); ?></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reporter</th>
                        <th>Type</th>
                        <th>Department</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Reported At</th>
                        <th>Assigned To</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($issues as $issue): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($issue['id']); ?></td>
                            <td><?php echo htmlspecialchars($issue['reporter_name']); ?></td>
                            <td><?php echo htmlspecialchars($issue['type_of_issue']); ?></td>
                            <td><?php echo htmlspecialchars($issue['department']); ?></td>
                            <td><?php echo htmlspecialchars($issue['room_number']); ?></td>
                            <td>
                                <span class="status-<?php echo htmlspecialchars($issue['status']); ?>">
                                    <?php echo ucfirst(htmlspecialchars($issue['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo date('Y-m-d H:i', strtotime($issue['reported_at'])); ?></td>
                            <td><?php echo htmlspecialchars($issue['technician_name'] ? $issue['technician_name'] : 'Not Assigned'); ?></td>
                            <td>
                                <?php if($issue['status'] == 'pending'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal<?php echo htmlspecialchars($issue['id']); ?>">
                                        Assign
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo htmlspecialchars($issue['id']); ?>">
                                    View
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Assign Modal -->
                        <div class="modal fade" id="assignModal<?php echo htmlspecialchars($issue['id']); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Assign Technician</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="assign_technician.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="issue_id" value="<?php echo htmlspecialchars($issue['id']); ?>">
                                            <div class="mb-3">
                                                <label for="technician" class="form-label">Select Technician</label>
                                                <select class="form-control" name="technician_id" required>
                                                    <option value="">Choose Technician</option>
                                                    <?php foreach($technicians as $tech): ?>
                                                        <option value="<?php echo htmlspecialchars($tech['id']); ?>">
                                                            <?php echo htmlspecialchars($tech['username']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Assign</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?php echo htmlspecialchars($issue['id']); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Issue Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Description:</strong></p>
                                        <p><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>
                                        <hr>
                                        <p><strong>Status Updates:</strong></p>
                                        <?php
                                        $stmt = $pdo->prepare("SELECT r.*, u.username FROM resolutions r 
                                                             LEFT JOIN users u ON r.updated_by = u.id 
                                                             WHERE r.issue_id = ? ORDER BY r.updated_at DESC");
                                        $stmt->execute([$issue['id']]);
                                        $updates = $stmt->fetchAll();
                                        
                                        foreach($updates as $update):
                                        ?>
                                            <div class="update-item">
                                                <small class="text-muted">
                                                    <?php echo date('Y-m-d H:i', strtotime($update['updated_at'])); ?> 
                                                    by <?php echo htmlspecialchars($update['username']); ?>
                                                </small>
                                                <p><?php echo htmlspecialchars($update['comments']); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
