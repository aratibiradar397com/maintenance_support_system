# Maintenance Support System - DY Patil College

A web-based maintenance support system for Dr D Y Patil Pratishthan's College of Engineering, Salokhenagar, Kolhapur. This system allows users to report maintenance issues and tracks their resolution through a streamlined process.

## Features

- User Registration and Authentication
- Issue Reporting System
- HOD Dashboard for Issue Management
- Technician Assignment and Status Updates
- Real-time Issue Tracking
- Responsive Design

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

## Installation

1. Clone or download the repository to your web server directory
2. Create a new MySQL database named `maintenance_system`
3. Import the database schema from `database.sql`
4. Configure the database connection in `config.php`
5. Ensure the web server has write permissions to the required directories

## Initial Setup

1. Create an admin (HOD) account:
```sql
INSERT INTO users (username, email, password, role, department) 
VALUES ('admin', 'admin@example.com', '$2y$10$YOUR_HASHED_PASSWORD', 'hod', 'CSE');
```

2. Create technician accounts:
```sql
INSERT INTO users (username, email, password, role, department) 
VALUES ('tech1', 'tech1@example.com', '$2y$10$YOUR_HASHED_PASSWORD', 'technician', 'CSE');
```

## Usage

1. Users can register and login to report maintenance issues
2. HODs can view all issues and assign them to technicians
3. Technicians can update the status of assigned issues
4. All users can track the progress of reported issues

## Security

- Passwords are hashed using PHP's password_hash() function
- SQL injection prevention using prepared statements
- Session-based authentication
- Input validation and sanitization

## Directory Structure

```
maintenance_support_system/
├── admin/
│   ├── dashboard.php
│   └── assign_technician.php
├── technician/
│   ├── dashboard.php
│   └── update_status.php
├── user/
│   └── report_issue.php
├── includes/
│   ├── navbar.php
│   └── footer.php
├── css/
│   └── style.css
├── config.php
├── index.php
├── login.php
├── register.php
└── README.md
```

## Contributing

If you'd like to contribute to this project, please:
1. Fork the repository
2. Create a new branch for your feature
3. Submit a pull request

## License

This project is licensed under the MIT License.
