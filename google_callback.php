<?php
require_once 'config.php';
require_once 'config/google_config.php';
require_once 'vendor/autoload.php';

// Initialize Google Client
$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);

try {
    // Get token from code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Get user profile
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists - log them in
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect to appropriate dashboard
        switch($user['role']) {
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
    } else {
        // New user - store in session and redirect to complete registration
        $_SESSION['google_signup'] = [
            'email' => $email,
            'fullname' => $name
        ];
        header("Location: complete_registration.php");
    }
} catch(Exception $e) {
    header("Location: index.php?error=" . urlencode("Google authentication failed. Please try again."));
}
exit();
