# Complete Docker PHP Development Environment Guide
# Version 0.1 
# Date: 2024-12-19

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

### Initial Setup

1. Open terminal/command prompt and navigate to where you store your programs for this course

2. Create a new project folder by cloaning the DMIT2025 folder
   ```bash
   git clone git@github.com:ileswade/DMIT2025.git
   # ren DMIT2025 projectname    # Windows
   # mv DMIT2025 projectname     # Mac
   ```

3. Remove the GIT repository
   ```bash
   # rm -rf .git                 # Mac
   # rm -r -force .git           # Windows - Powershell
   # rmdir /s /q .git            # Windows - CMD
   ```

4. Recreate a new GIT repository (Optional)
   ```bash
   git init
   git add .
   git commit -m "Initial Commit'
   ```

5. Look for and review current configuration files:
   - `docker-compose.yml`: Serves as the instructions to start the Docker Containers representing the PHP Web server and MYSQL server
   - `php.ini`: Serves as configuration information used by the PHP server
   - `index.php`: Default "PHP Info" to display the version of the current PHP Server software


### Starting Your Environment

1. Open terminal/command prompt in your project folder

2. Start the Docker containers:

   ```bash
   docker compose up -d
   ```

   First run will take several minutes to download images

3. Test your setup by visiting:

   - PHP Application: [http://localhost:8080](http://localhost:8080)
   - phpMyAdmin: [http://localhost:8081](http://localhost:8081)

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

#### Connecting from PHP

Use this code template for database connections:

```php
   <?php
   $host = 'mysql';  // Docker service name
   $dbname = 'php_course';
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

    project_folder/
    ├── docker-compose.yml
    ├── php.ini
    ├── README.md
    ├── PROJECT.md
    ├── init-scripts/
    │   └── 01-create-tables.sql
    ├── php/
    │   └── index.php
    └── mysql_data/

4. Environment Features:
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

For any course submissions, check with your instructor if you need to submit the database 'as is' (Database State) or if you will can remove the database and provide 'just the scripts to rebuild and populate the database'

### Option 1: Submit with Database State

1. Leave your mysql_data folder in place
2. Zip your entire project folder
3. Name it: `surname_firstname_projectname.zip`

### Option 2: Submit without Database State

If the project does not require a database, OR if the script file will populate the insital data for the instructor, you do NOT need to submit the Database State.  

1. Delete the mysql_data folder
2. Zip your entire project folder
3. Name it: `surname_firstname_projectname.zip`
