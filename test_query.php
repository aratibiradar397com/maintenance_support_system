<?php
require_once 'config.php';

// Test query to check issues
$stmt = $pdo->query("SELECT COUNT(*) as count FROM issues");
$result = $stmt->fetch();
echo "Total issues: " . $result['count'] . "\n";

// Test query to check users
$stmt = $pdo->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
$users = $stmt->fetchAll();
echo "\nUsers by role:\n";
foreach ($users as $user) {
    echo $user['role'] . ": " . $user['count'] . "\n";
}
