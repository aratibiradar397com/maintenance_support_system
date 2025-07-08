CREATE DATABASE maintenance_system;
USE maintenance_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('user', 'hod', 'technician', 'admin') NOT NULL DEFAULT 'user',
    department VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type_of_issue VARCHAR(100) NOT NULL,
    department VARCHAR(50) NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('pending', 'assigned', 'in_progress', 'resolved') DEFAULT 'pending',
    reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    assigned_technician_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (assigned_technician_id) REFERENCES users(id)
);

CREATE TABLE issue_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_id INT,
    updated_by INT,
    status_change VARCHAR(50),
    comments TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id) REFERENCES issues(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);
