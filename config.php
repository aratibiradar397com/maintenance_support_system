<?php
// Database configuration
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'maintenance_system';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

// Error reporting - disable in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$debug_mode = true; // Set to false in production

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    if ($debug_mode) {
        echo "Error: Unable to connect to the database. Please check your configuration.";
    } else {
        echo "Connection failed. Please try again later.";
    }
    exit;
}

// Define base URL dynamically
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
          . "://" . $_SERVER['HTTP_HOST']
          . rtrim(dirname($_SERVER['PHP_SELF']), '/');

// Start session safely
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'use_strict_mode' => true,
    ]);
}

// Session timeout logic
if (!empty($_SESSION['user_id']) && isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > 1800) { // 30 minutes
        session_unset();
        session_destroy();
        header("Location: $base_url/login.php?timeout=true");
        exit;
    }
}
$_SESSION['last_activity'] = time(); // Update timestamp

// Define role constants
define('ROLE_ADMIN', 'admin');
define('ROLE_HOD', 'hod');
define('ROLE_TECHNICIAN', 'technician');
define('ROLE_USER', 'user');
