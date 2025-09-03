# Creating New Projects Guide

## Overview
This development environment supports multiple projects in a single Docker setup. Each project gets its own folder and database, eliminating port conflicts and setup repetition.

## Quick Start - Creating a New Project

### Step 1: Create Project Folder
```bash
# Navigate to the php directory
cd php

# Create your project folder (use descriptive names)
mkdir lab1              # For Lab 1
mkdir assignment2       # For Assignment 2  
mkdir final-project     # For your final project
```

### Step 2: Create Initial Files
```bash
# Go into your project folder
cd lab1

# Create your main PHP file
touch index.php

# Initialize git for this specific project (optional)
git init
```

### Step 3: Add Starter Code
Create your `index.php` with this template:

```php
<?php
// Include the shared database utility
require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 1 - Your Name</title>
</head>
<body>
    <h1>Lab 1 Project</h1>
    
    <?php
    try {
        // Get database connection (auto-detects this is 'lab1' project)
        $pdo = getDatabase();
        echo "<p>✅ Database connected successfully!</p>";
        
        // Your PHP code here
        
    } catch (Exception $e) {
        echo "<p>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
```

### Step 4: Access Your Project
Open your browser and go to: `http://localhost:8080/lab1/`

Your project now has:
- ✅ Its own URL path
- ✅ Its own database (`php_course_lab1`)
- ✅ Full isolation from other projects

## Database Usage

### Automatic Database Creation
When you first access your project, a database named `php_course_[project-name]` is automatically created.

### Using the Database Helper
```php
// Include the helper (from any project folder)
require_once '../shared/database.php';

// Get connection for current project (auto-detected)
$pdo = getDatabase();

// Or specify a different project's database
$pdo = getDatabase('lab2');
```

### Database Connection Details
- **Host:** `mysql` (from PHP) or `localhost` (external tools)
- **Username:** `student`
- **Password:** `student`
- **Database Name:** `php_course_[your-project-name]`

### Creating Tables
```php
// Example: Create a users table for this project
$pdo = getDatabase();

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($sql);
echo "Table created successfully!";
```

## Project Structure Recommendations

### Organize Your Files
```
php/
├── lab1/
│   ├── index.php           # Main page
│   ├── process.php         # Form processing
│   ├── styles.css          # CSS (if not using external)
│   └── includes/           # Reusable components
│       ├── header.php
│       └── footer.php
├── lab2/
│   ├── index.php
│   └── admin/              # Admin section
│       └── index.php
└── shared/                 # Don't modify this folder
    ├── database.php        # Database helper
    └── test-db.php         # Connection tester
```

### Access Patterns
- Main project: `http://localhost:8080/lab1/`
- Sub-pages: `http://localhost:8080/lab1/process.php`
- Admin areas: `http://localhost:8080/lab2/admin/`

## Git Workflow for Projects

### Option 1: Individual Project Repos
```bash
cd php/lab1
git init
git add .
git commit -m "Initial lab 1 setup"
git remote add origin [your-repo-url]
git push -u origin main
```

### Option 2: Single Repo with Multiple Projects
```bash
# From the main project directory (not inside php/)
git add php/lab1/
git commit -m "Add lab 1 project"
```

## Common Tasks

### View All Projects
Visit `http://localhost:8080/` to see a dashboard of all your projects.

### Database Management
- **phpMyAdmin:** `http://localhost:8081` (student/student)
- **Test Connections:** `http://localhost:8080/shared/test-db.php`

### Sharing Code Between Projects
```php
// Create shared utilities in the shared folder
// php/shared/utilities.php

// Use from any project
require_once '../shared/utilities.php';
require_once '../shared/database.php';
```

### Copying Starter Files
```bash
# Copy from a template project
cp -r php/lab1/ php/lab2/
cd php/lab2
# Edit files to customize for lab2
```

## Troubleshooting

### Database Issues
1. Check the database connection test: `http://localhost:8080/shared/test-db.php`
2. Verify your project folder name matches the database name
3. Ensure Docker containers are running: `docker compose ps`

### File Not Found
1. Ensure `index.php` exists in your project folder
2. Check file permissions
3. Verify the URL path matches your folder structure

### Port Already in Use
This setup eliminates port conflicts! All projects share the same Docker environment but have separate databases and URL paths.

## Best Practices

### Naming Conventions
- Use descriptive folder names: `user-management`, `shopping-cart`, `lab1`
- Avoid spaces in folder names (use hyphens or underscores)
- Keep folder names short but clear

### Database Design
- Each project should have its own tables
- Use descriptive table names: `lab1_users`, `cart_items`
- Don't access other projects' databases unless specifically needed

### Code Organization
- Keep project files contained within their folders
- Use the shared folder for common utilities only
- Include meaningful comments and documentation

## Simple Command-Line Tools

### 🛠️ **Create Database (from your project folder):**
```bash
cd php/lab1
php ../shared/create-database.php
```
- Creates your project database if it doesn't exist
- Generates connection example code
- Verifies everything is working

### 📦 **Backup Database for Submission (from your project folder):**
```bash
cd php/lab1
php ../shared/backup-database.php
```
- Exports your database structure and data
- Creates SQL file in your project folder
- Ready for submission to instructor

## Getting Help

1. **Dashboard:** `http://localhost:8080/` - Overview of all projects
2. **Database Test:** `http://localhost:8080/shared/test-db.php` - Connection testing
3. **phpMyAdmin:** `http://localhost:8081/` - Database management
4. **Export Tool:** `http://localhost:8080/shared/export-database.php` - Web-based backup
5. **PHP Info:** `http://localhost:8080/?phpinfo=1` - PHP configuration

Happy coding! 🚀