<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'config.php'; // Ensure this file exists and is correctly configured

header('Content-Type: application/json');
$response = ['success' => false, 'error' => '', 'redirect' => ''];

require_once 'config.php'; // Database connection
error_log(json_encode($response));

header('Content-Type: application/json');
$response = ['success' => false, 'error' => '', 'redirect' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $response['error'] = 'Please enter both username and password.';
        echo json_encode($response);
        exit;
    }

    // Query to fetch user details
    $stmt = $pdo->prepare("SELECT id, fullname, username, password, role, department FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'] ?? 'N/A';
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['department'] = $user['department'] ?? 'General';

        $response['success'] = true;

        // Redirect based on role
        switch ($user['role']) {
            case 'hod':
                $response['redirect'] = 'admin/dashboard.php';
                break;
            case 'technician':
                $response['redirect'] = 'technician/dashboard.php';
                break;
            case 'admin':
                $response['redirect'] = 'admin/dashboard.php';
                break;
            default:
                $response['redirect'] = 'user/dashboard.php';
                break;
        }
    } else {
        $response['error'] = 'Invalid username or password.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

echo json_encode($response);
