<?php
require_once 'config.php';

// Check if user came from Google signup
if (!isset($_SESSION['google_signup'])) {
    header("Location: index.php");
    exit();
}

$google_data = $_SESSION['google_signup'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $department = $_POST['department'];
    
    // Generate random password for Google users
    $random_password = bin2hex(random_bytes(8));
    $hashed_password = password_hash($random_password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password, role, department) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $google_data['fullname'], $google_data['email'], $username, $hashed_password, $role, $department);
    
    if ($stmt->execute()) {
        // Clear Google signup data
        unset($_SESSION['google_signup']);
        
        // Log user in
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        // Redirect to appropriate dashboard
        switch($role) {
            case 'hod':
                header("Location: admin/dashboard.php");
                break;
            case 'technician':
                header("Location: technician/dashboard.php");
                break;
            default:
                header("Location: user/dashboard.php");
                break;
        }
        exit();
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Registration - Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Complete Your Registration</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($google_data['fullname']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($google_data['email']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Choose a Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="user">Student/Staff</option>
                                    <option value="hod">Department Head</option>
                                    <option value="technician">Technician</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="Computer">Computer Engineering</option>
                                    <option value="IT">Information Technology</option>
                                    <option value="Mechanical">Mechanical Engineering</option>
                                    <option value="Civil">Civil Engineering</option>
                                    <option value="E&TC">Electronics & Telecommunication</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Complete Registration</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
