<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-4">Our Services</h1>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Infrastructure Maintenance</h3>
                            <ul class="text-dark list-unstyled">
                                <li>✓ Classroom repairs</li>
                                <li>✓ Laboratory maintenance</li>
                                <li>✓ Building infrastructure</li>
                                <li>✓ Electrical systems</li>
                                <li>✓ Plumbing services</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Equipment Support</h3>
                            <ul class="text-dark list-unstyled">
                                <li>✓ Laboratory equipment</li>
                                <li>✓ Computer hardware</li>
                                <li>✓ Projector systems</li>
                                <li>✓ Network infrastructure</li>
                                <li>✓ HVAC systems</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Emergency Services</h3>
                            <ul class="text-dark list-unstyled">
                                <li>✓ 24/7 emergency support</li>
                                <li>✓ Power backup systems</li>
                                <li>✓ Safety equipment</li>
                                <li>✓ Fire safety systems</li>
                                <li>✓ Emergency repairs</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <h2 class="mb-4">Need Maintenance Support?</h2>
                    <p class="lead mb-4">Register now to submit your maintenance requests</p>
                    <a href="register.php?role=user" class="btn btn-primary btn-lg">Register Now</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
