<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-4">About Our Maintenance Support System</h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h2 class="card-title text-dark mb-4">Our Mission</h2>
                            <p class="card-text text-dark">
                                The DY Patil College Maintenance Support System is designed to streamline and improve the maintenance request process across our campus. Our platform enables efficient communication between students, staff, department heads, and maintenance personnel.
                            </p>
                            
                            <h3 class="text-dark mt-4 mb-3">Key Features</h3>
                            <ul class="text-dark">
                                <li>Easy issue reporting for students and staff</li>
                                <li>Real-time tracking of maintenance requests</li>
                                <li>Efficient assignment of technicians</li>
                                <li>Department-wise issue management</li>
                                <li>Status updates and notifications</li>
                            </ul>

                            <h3 class="text-dark mt-4 mb-3">How It Works</h3>
                            <ol class="text-dark">
                                <li>Users report maintenance issues through the platform</li>
                                <li>Department heads review and prioritize requests</li>
                                <li>Technicians are assigned to resolve issues</li>
                                <li>Users can track the status of their requests</li>
                                <li>Issues are marked as resolved upon completion</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
