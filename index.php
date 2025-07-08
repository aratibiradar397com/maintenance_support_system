<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DY Patil College - Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/college.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            padding: 2rem 0;
        }

        .registration-buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 3rem 0;
            flex-wrap: wrap;
            padding: 0 15px;
        }

        .registration-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            width: 300px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            transition: transform 0.3s ease;
        }

        .registration-card:hover .icon-circle {
            transform: scale(1.1);
        }

        .btn-register {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            margin-top: 20px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-register:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .role-title {
            font-size: 1.4rem;
            margin: 15px 0;
            color: white;
            font-weight: 600;
        }

        .role-description {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .login-section {
            margin-top: 2rem;
        }

        .login-link {
            color: #007bff;
            background: white;
            padding: 10px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .login-link:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 992px) {
            .registration-buttons {
                gap: 20px;
            }
            .registration-card {
                width: 280px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0;
            }
            .registration-buttons {
                flex-direction: column;
                align-items: center;
                gap: 25px;
            }
            .registration-card {
                width: 100%;
                max-width: 320px;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section h2 {
                font-size: 1.5rem;
            }
            .registration-card {
                padding: 20px;
            }
            .icon-circle {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-3">Welcome to Maintenance Support System</h1>
            <h2 class="h3 mb-4">Dr. D.Y. Patil Pratishthans College of Engineering</h2>
            <p class="lead mb-5">Report and track maintenance issues efficiently</p>

            <div class="registration-buttons">
                <div class="registration-card">
                    <div class="icon-circle">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="role-title">Student/Staff</h3>
                    <p class="role-description">Register as a user to report maintenance issues and track their status</p>
                    <a href="register.php?role=user" class="btn btn-register">
                        Register as User
                    </a>
                </div>

                <div class="registration-card">
                    <div class="icon-circle">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="role-title">Department Head</h3>
                    <p class="role-description">Register as HOD to manage and oversee department maintenance</p>
                    <a href="register.php?role=hod" class="btn btn-register">
                        Register as HOD
                    </a>
                </div>

                <div class="registration-card">
                    <div class="icon-circle">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="role-title">Technician</h3>
                    <p class="role-description">Register as technician to handle and resolve maintenance issues</p>
                    <a href="register.php?role=technician" class="btn btn-register">
                        Register as Technician
                    </a>
                </div>
            </div>

            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="login-section">
                <p class="text-white mb-3">Already have an account?</p>
                <a href="login.php" class="login-link">
                    <i class="fas fa-sign-in-alt me-2"></i>Login Here
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
