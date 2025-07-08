<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Create database
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop and create database
    $pdo->exec("DROP DATABASE IF EXISTS maintenance_system");
    $pdo->exec("CREATE DATABASE maintenance_system");
    echo "Database created successfully<br>";
    
    // Connect to the new database
    $pdo = new PDO("mysql:host=$host;dbname=maintenance_system", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table
    $pdo->exec("CREATE TABLE users (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        role ENUM('user', 'hod', 'technician') NOT NULL,
        department VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_username (username),
        UNIQUE KEY unique_email (email)
    ) ENGINE=InnoDB");
    echo "Users table created successfully<br>";
    
    // Create issues table
    $pdo->exec("CREATE TABLE issues (
        id INT NOT NULL AUTO_INCREMENT,
        user_id INT,
        type_of_issue VARCHAR(100) NOT NULL,
        department VARCHAR(50) NOT NULL,
        room_number VARCHAR(20) NOT NULL,
        description TEXT NOT NULL,
        status ENUM('pending', 'assigned', 'in_progress', 'resolved') DEFAULT 'pending',
        reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        resolved_at TIMESTAMP NULL,
        assigned_technician_id INT,
        PRIMARY KEY (id),
        KEY fk_user (user_id),
        KEY fk_technician (assigned_technician_id),
        CONSTRAINT fk_issues_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
        CONSTRAINT fk_issues_technician FOREIGN KEY (assigned_technician_id) REFERENCES users (id) ON DELETE SET NULL
    ) ENGINE=InnoDB");
    echo "Issues table created successfully<br>";

    // Create resolutions table
    $pdo->exec("CREATE TABLE resolutions (
        id INT NOT NULL AUTO_INCREMENT,
        issue_id INT NOT NULL,
        resolved_by INT,
        resolution_details TEXT NOT NULL,
        resolved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY fk_issue (issue_id),
        KEY fk_resolver (resolved_by),
        CONSTRAINT fk_resolutions_issue FOREIGN KEY (issue_id) REFERENCES issues (id) ON DELETE CASCADE,
        CONSTRAINT fk_resolutions_resolver FOREIGN KEY (resolved_by) REFERENCES users (id) ON DELETE SET NULL
    ) ENGINE=InnoDB");
    echo "Resolutions table created successfully<br>";

    echo "<br>Setup completed successfully!<br>";
    echo "Please register new accounts for HOD, technician, and users through the registration page.";
    
    // Redirect to login page after 5 seconds
    echo "<script>
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 5000);
    </script>";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
