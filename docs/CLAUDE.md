# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Environment

This is a Docker-based PHP development environment with MySQL and phpMyAdmin for web application development courses (DMIT2025).

### Key Commands

**Start the development environment:**
```bash
docker compose up -d
```

**Stop the environment:**
```bash
docker compose down
```

**Stop and remove all data (recreates database from scratch):**
```bash
docker compose down -v
rm -rf mysql_data
docker compose up -d
```

**View logs:**
```bash
docker compose logs
```

**Restart specific service:**
```bash
docker compose restart web
```

**Install PHP dependencies:**
```bash
# Dependencies are auto-installed on container startup via composer install
# If you need to manually install: docker compose exec web composer install
```

### Architecture

**Services:**
- `web`: PHP 8.2 with Apache, serves files from `php/` directory on port 8080
- `mysql`: MySQL 8.0 database on port 3306
- `phpmyadmin`: Web interface for MySQL on port 8081

**Directory Structure:**
- `php/`: All PHP application files go here
- `init-scripts/`: SQL scripts that run once when MySQL container is first created (alphabetical order)
- `mysql_data/`: Database files (auto-created, don't modify manually)
- `docker-compose.yaml`: Container configuration
- `php.ini`: PHP configuration

### Database Configuration

**Connection details:**
- Host: `mysql` (from PHP containers) or `localhost` (external)
- Database: `php_course` 
- Username: `student`
- Password: `student`
- Root password: `studentpass`

**PDO Connection Template:**
```php
$pdo = new PDO("mysql:host=mysql;dbname=php_course", "student", "student");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### Access Points

- PHP Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (student/student or root/studentpass)
- MySQL Direct: localhost:3306

### Development Notes

- PHP files must be placed in the `php/` directory to be served
- Database initialization scripts in `init-scripts/` run only on first container creation
- Composer dependencies are defined in `php/composer.json` and auto-installed
- PHP errors display in browser (configured for development)
- Apache mod_rewrite is enabled
- PHP configuration allows 64MB uploads and 256MB memory limit