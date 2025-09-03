# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Environment

This is a Docker-based PHP development environment designed for web application development courses (DMIT2025). It supports multi-project development with isolated databases and shared utilities.

### Essential Commands

**Start the development environment:**
```bash
docker compose up -d
```

**Stop the environment:**
```bash
docker compose down
```

**Reset database (recreates all databases from init scripts):**
```bash
docker compose down -v
rm -rf mysql_data
docker compose up -d
```

**View container logs:**
```bash
docker compose logs
# For specific service: docker compose logs web
```

**Access container shell:**
```bash
docker compose exec web bash
```

**Install new Composer dependencies:**
```bash
docker compose exec web composer install
```

### Architecture Overview

**Multi-Project Structure:**
- Projects are organized in separate folders under `php/`
- Each project gets its own database: `php_course_[project-name]`
- Shared utilities in `php/shared/` provide database connections and export tools
- Project dashboard at root shows all available projects

**Services:**
- `web`: PHP 8.2-apache serving `php/` directory on port 8080
- `mysql`: MySQL 8.0 with project-specific databases on port 3306  
- `phpmyadmin`: Database management interface on port 8081

**Key Directories:**
- `php/[project-name]/`: Individual project folders (lab1, lab2, assignment1, etc.)
- `php/shared/`: Database utilities and export tools shared across projects
- `init-scripts/`: SQL initialization scripts (run once on first container startup)
- `mysql_data/`: Persistent database storage (auto-created)

### Database System

**On-Demand Database Architecture:**
- Default database: `php_course` (always available)
- Project databases: `php_course_lab1`, `php_course_lab2`, etc. (created only when needed)
- Students create databases via "Reset Database" button in each project

**Connection Details:**
- Host: `mysql` (within containers) or `localhost` (external access)
- Username: `student` / Password: `student`
- Root: `root` / Password: `studentpass`

**Database Helper Usage:**
```php
// Auto-detects current project and connects to appropriate database
require_once '../shared/database.php';
$pdo = getDatabase();

// Connect to specific project database
$pdo = getDatabase('lab1');
```

**Manual PDO Connection:**
```php
$pdo = new PDO("mysql:host=mysql;dbname=php_course_lab1", "student", "student");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### Project Workflow

**Creating New Projects:**
1. Create folder: `mkdir php/lab3`
2. Add main file: `touch php/lab3/index.php`
3. Access at: `http://localhost:8080/lab3/`
4. Database auto-created as `php_course_lab3`

**Submission Process:**
1. Navigate to project: `cd php/lab1`
2. Export database: `php ../shared/backup-database.php`
3. Create zip with project files + generated SQL backup

### Access Points

- **Project Dashboard**: http://localhost:8080 - Lists all projects and tools
- **phpMyAdmin**: http://localhost:8081 (student/student or root/studentpass)
- **Individual Projects**: http://localhost:8080/[project-name]/
- **Database Export Tool**: http://localhost:8080/shared/export-database.php

### Dependencies

**PHP Packages (composer.json):**
- PHPMailer 6.9+ for email functionality

**Container Features:**
- PHP 8.2 with PDO MySQL extensions
- Apache with mod_rewrite enabled
- Composer auto-installation on startup
- Development error display enabled
- 64MB upload limit, 256MB memory limit

### Development Notes

**File Organization:**
- All PHP code must be in `php/` directory tree
- Database scripts in `init-scripts/` run alphabetically on first MySQL startup
- Use `php/shared/database.php` instead of manual PDO connections
- Project isolation prevents database conflicts between assignments

**Database Management:**
- Only base MySQL environment is initialized automatically
- Students create project databases on-demand using "Reset Database" buttons
- Each project gets isolated database namespace when created
- No databases created unless student specifically needs them for a lab

**Shared Utilities:**
- `php/shared/database.php`: Auto-detecting database connections
- `php/shared/backup-database.php`: Project-specific database exports
- `php/shared/export-database.php`: Web interface for database exports
- `php/shared/test-db.php`: Connection testing utility