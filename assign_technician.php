<?php
require_once '../config.php';

// Check if user is logged in and is HOD
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hod') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = $_POST['issue_id'];
    $technician_id = $_POST['technician_id'];
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Update issue with assigned technician
        $stmt = $pdo->prepare("UPDATE issues SET assigned_technician_id = ?, status = 'assigned' WHERE id = ?");
        $stmt->execute([$technician_id, $issue_id]);
        
        // Add assignment update
        $stmt = $pdo->prepare("INSERT INTO resolutions (issue_id, updated_by, status_change, comments) VALUES (?, ?, 'assigned', 'Issue assigned to technician')");
        $stmt->execute([$issue_id, $_SESSION['user_id']]);
        
        // Commit transaction
        $pdo->commit();
        
        header("Location: dashboard.php?assigned=1");
    } catch(PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        header("Location: dashboard.php?error=1");
    }
} else {
    header("Location: dashboard.php");
}
exit();
