# Complete Docker PHP Development Environment Guide
## Version 0.1 
### Date: 2024-12-19

## Table of Contents
1. Installing Docker
2. Setting Up Your Development Environment
3. Working with the Database
4. Troubleshooting and Management
5. Submission Instructions

## Part 1: Installing Docker

### Windows Installation

1. Download Docker Desktop for Windows from [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

2. Run the installer with default settings

3. Restart your computer when prompted

4. Open PowerShell or Command Prompt and verify installation:

   ```bash
   docker --version
   docker compose version
   ```

### Mac Installation

1. Download Docker Desktop for Mac from [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

2. For Apple Silicon (M1/M2) Macs, use the Apple Silicon version

3. Open the .dmg file and drag Docker to Applications

4. Open Docker from Applications folder

5. Open Terminal and verify installation:
   ```bash
   docker --version
   docker compose version
   ```

## Part 2: Setting Up Your Development Environment

### Initial Setup (One-Time Only)

1. Open terminal/command prompt and navigate to where you store your programs for this course

2. Clone the DMIT2025 development environment
   ```bash
   git clone git@github.com:ileswade/DMIT2025.git
   cd DMIT2025
   ```

3. Review the configuration files:
   - `docker-compose.yml`: Instructions to start the Docker containers (PHP web server and MySQL server)
   - `php.ini`: PHP server configuration
   - `php/index.php`: Project dashboard and PHP info display

### Multi-Project Workflow (NEW!)

**This environment now supports multiple projects without port conflicts or repeated setup!**

#### Creating Your First Project

1. **Start the environment** (one-time setup):
   ```bash
   docker compose up -d
   ```

2. **Create a new project folder**:
   ```bash
   mkdir php/lab1        # For Lab 1
   mkdir php/lab2        # For Lab 2
   mkdir php/assignment1 # For assignments
   ```

3. **Create your project files**:
   ```bash
   cd php/lab1
   # Create your main PHP file
   touch index.php
   
   # Initialize git for this specific project (recommended)
   git init
   git add .
   git commit -m "Initial lab1 setup"
   ```

4. **Access your projects**:
   - Lab 1: [http://localhost:8080/lab1/](http://localhost:8080/lab1/)
   - Lab 2: [http://localhost:8080/lab2/](http://localhost:8080/lab2/)
   - Main dashboard: [http://localhost:8080](http://localhost:8080)

#### Project Benefits
- ✅ **No port conflicts** - all projects share the same Docker environment
- ✅ **Separate databases** - each project gets `php_course_[project-name]`
- ✅ **Easy switching** - work on multiple projects simultaneously
- ✅ **Individual git repos** - each project can have its own version control


### Starting Your Environment

1. Open terminal/command prompt in the main project folder (where `docker-compose.yaml` is located)

2. Start the Docker containers:

   ```bash
   docker compose up -d
   ```

   First run will take several minutes to download images

3. Test your setup by visiting:

   - **Project Dashboard**: [http://localhost:8080](http://localhost:8080) - Shows all your projects
   - **phpMyAdmin**: [http://localhost:8081](http://localhost:8081) - Database management
   - **Example Project**: [http://localhost:8080/lab1/](http://localhost:8080/lab1/) - Sample project

## Part 3: Working with the Database

### Database Initialization Scripts

1. Look for the `init-scripts` folder which contains database server scripts that are ran (in alphabetical order) when first setting up the MYSQL server.

2. Look for a 'placeholder' initialization script `init-scripts/01-create-tables.sql` which creat a disposable database and inital `users` table and adds two records to the table

Important notes about initialization scripts:

- Scripts run automatically when MySQL container is first created
- Files execute in alphabetical order (use prefixes like '01-', '02-')
- To re-run initialization scripts, you need to
   - `docker compose down -v`,
   - then remove the mysql_data folder, and then `docker compose up -d` (This will destroy the exsiting database),
   - recreate the data folder and the run the scripts again.


### Database Access

#### Using phpMyAdmin
1. Access phpMyAdmin at [http://localhost:8081](http://localhost:8081)
2. Login credentials:
   - Regular user:
     - Username: `student`
     - Password: `student`
   - Root access:
     - Username: `root`
     - Password: `studentpass`

#### Connecting from PHP (NEW Easy Method)

Use the shared database helper for automatic project detection:

```php
<?php
// Include the shared database utility
require_once '../shared/database.php';

try {
    // Auto-detects your project and connects to the right database
    $pdo = getDatabase();
    echo "Connected successfully to your project database!";
    
    // Create tables, insert data, etc.
    
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
```

#### Manual Connection (Advanced)

If you need to connect manually or to a specific project's database:

```php
<?php
$host = 'mysql';  // Docker service name
$dbname = 'php_course_lab1';  // Your specific project database
$username = 'student';
$password = 'student';

try {
   $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "Connected successfully";
} catch(PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}
```

## Part 4: Troubleshooting and Management

### Common Commands

- Start containers:

  ```bash
  docker compose up -d
  ```

- Stop containers:

  ```bash
  docker compose down
  ```

- View running containers:

  ```bash
  docker ps
  ```

- View logs:

  ```bash
  docker compose logs
  ```

- Restart specific service:

  ```bash
  docker compose restart web
  ```

### Important Notes

1. File Structure:
   - All PHP files go in your `php` folder within the project folder 
   - SQL initialization scripts go in `init-scripts` folder
   - Database files are stored in Docker volume `mysql_data` (Don't modify these files)

2. Access Points:
    - PHP Application: [http://localhost:8080](http://localhost:8080)
    - phpMyAdmin: [http://localhost:8081](http://localhost:8081)
        - Username: `student`
        - Password: `student`
        - Root Password: `studentpass`
    - MySQL: localhost:3306
        - Host: `mysql` (use 'localhost' outside Docker)
        - Port: `3306`
        - Database: `php_course`
        - Username: `student`
        - Password: `student`

3. Project Structure
```text
    project_folder/
    ├── docker-compose.yml
    ├── php.ini
    ├── README.md
    ├── PROJECT.md
    ├── NEW-PROJECT-SETUP.md        # How to create new projects
    ├── init-scripts/
    │   └── 01-create-tables.sql    # Creates all project databases
    ├── php/
    │   ├── index.php               # Project dashboard
    │   ├── shared/                 # Shared utilities
    │   │   ├── database.php        # Database helper
    │   │   └── test-db.php         # Connection testing
    │   ├── lab1/                   # Your Lab 1 project
    │   │   └── index.php
    │   ├── lab2/                   # Your Lab 2 project
    │   └── assignment1/            # Your assignment project
    └── mysql_data/
```
4. Environment Features:
   - **Multi-project support** - work on multiple projects simultaneously
   - **Automatic database creation** - each project gets its own database
   - **Project dashboard** - view all projects at http://localhost:8080
   - **Shared utilities** - database helper and testing tools
   - PHP errors display in browser
   - MySQL data persists between restarts
   - Automatic container restart on failure
   - URL rewriting enabled
   - PDO and MySQL extensions installed

5. Common Issues:
   - Port conflicts: Change ports in docker-compose.yml if 8080/8081/3306 are in use
   - Permission issues: Ensure write permissions on project folder
   - Container startup: Check logs with `docker compose logs` if services don't start

## Part 5: Submission Instructions

### 📦 **NEW: Super Simple Submission Process**

Each project now has easy tools to prepare submissions with database data included.

#### **Easy Database Backup (from your project folder):**

1. **Navigate to your project:**
   ```bash
   cd php/lab1                    # Go into your specific project
   ```

2. **Backup your database:**
   ```bash
   php ../shared/backup-database.php # Creates SQL backup file automatically
   ```

3. **Zip your project:**
   ```bash
   # Zip the entire project folder (from parent directory)
   cd ..
   zip -r LastName_FirstName_Lab1.zip lab1/
   ```

The backup script automatically:
- ✅ Detects which project you're working on
- ✅ Exports your exact database structure and data  
- ✅ Creates a SQL file in your project folder
- ✅ Ready for instructor import

#### **Alternative: Use Web Interface**
- Visit: http://localhost:8080/shared/export-database.php
- Select your project and export database

### **What to Submit:**
Your zip file should contain:
```
LastName_FirstName_Lab1.zip
└── lab1/
    ├── index.php                    # Your PHP files
    ├── process.php                  
    ├── styles.css                   # Other files
    └── database-backup-lab1.sql     # 🎯 DATABASE BACKUP
```

### **For Instructors:**
To recreate student work:
1. Extract the zip file
2. Import the SQL file into MySQL/phpMyAdmin  
3. Test the PHP code against the imported database

**No more mysql_data folders or complex setup needed!** 🎉

---

## 📚 Additional Documentation

- **[📋 Complete Student Submission Guide](docs/STUDENT-SUBMISSION-GUIDE.md)** - Step-by-step submission process
- **[🛠️ New Project Setup Guide](docs/NEW-PROJECT-SETUP.md)** - How to create and manage projects  
- **[🏗️ Project Template](docs/PROJECT.md)** - Template for project documentation
- **[🤖 Claude Code Guide](docs/CLAUDE.md)** - For AI development assistance

All documentation is organized in the `docs/` folder for easy access.
