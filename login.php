<?php
require_once 'config.php'; // Include your database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    $errors = [];

    // Sanitize user input
    $username = htmlspecialchars($username);

    // Query to check if the user exists
    $stmt = $pdo->prepare("SELECT id, fullname, username, password, role, department FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Start the session and store user information
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['department'] = $user['department'];

        // Redirect based on role
        switch ($user['role']) {
            case 'hod':
                header("Location: admin/dashboard.php");
                exit();
            case 'technician':
                header("Location: technician/dashboard.php");
                exit();
            case 'admin':
                header("Location: admin/dashboard.php");
                exit();
            default:
                header("Location: user/dashboard.php");
                exit();
        }
    } else {
        $errors[] = "Invalid username or password.";
    }
}
?>

<?php include 'includes/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DY Patil College Maintenance Support System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-3">Login to Maintenance Support System</h1>
            <p class="lead mb-5">Please enter your credentials to access the system</p>

            <!-- Login form -->
            <div class="login-card">
                <div class="icon-circle">
                    <i class="fas fa-sign-in-alt"></i>
                </div>

                <!-- PHP Login Form -->
                <h1>Login</h1>

                <?php
                if (!empty($errors)) {
                    echo '<p class="error-message">' . implode('<br>', $errors) . '</p>';
                }
                ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <p class="signup-link">Don't have an account? <a href="register.php" class="login-link">Sign Up</a></p>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
