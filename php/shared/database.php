<?php
/**
 * Database Connection Utility for Multi-Project Environment
 * 
 * This utility automatically determines which database to use based on the current project folder.
 * Each project gets its own database to avoid conflicts.
 * 
 * Usage:
 * 1. Include this file in your project: require_once '../shared/database.php';
 * 2. Use getDatabase() to get a PDO connection for your current project
 * 3. Or use getDatabase('specific_project') to connect to a specific project database
 */

/**
 * Get database connection for current project or specified project
 * @param string|null $project_name Optional project name override
 * @return PDO Database connection
 * @throws Exception If connection fails
 */
function getDatabase($project_name = null) {
    $host = 'mysql';  // Docker service name
    $username = 'student';
    $password = 'student';
    
    // Auto-detect project name from current directory if not specified
    if ($project_name === null) {
        $project_name = getCurrentProjectName();
    }
    
    // Build database name
    $dbname = $project_name === 'root' ? 'php_course' : "php_course_{$project_name}";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch(PDOException $e) {
        // Check if it's a "database doesn't exist" error
        if (strpos($e->getMessage(), '1049') !== false || strpos($e->getMessage(), "Unknown database") !== false) {
            throw new Exception("Database '{$dbname}' does not exist yet. Click 'Reset Database' to create it.");
        }
        throw new Exception("Database connection failed for project '{$project_name}': " . $e->getMessage());
    }
}

/**
 * Auto-detect current project name based on directory structure
 * @return string Project name
 */
function getCurrentProjectName() {
    $script_path = $_SERVER['SCRIPT_NAME'];
    $path_parts = explode('/', trim($script_path, '/'));
    
    // If we're in the root php directory, return 'root'
    if (count($path_parts) <= 1 || empty($path_parts[0])) {
        return 'root';
    }
    
    // Return the first directory name (project folder)
    return $path_parts[0];
}

/**
 * Get list of available project databases (only ones that actually exist)
 * @return array List of project names that have databases
 */
function getAvailableProjects() {
    try {
        $pdo = new PDO("mysql:host=mysql", 'student', 'student');
        $stmt = $pdo->query("SHOW DATABASES LIKE 'php_course%'");
        $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $projects = [];
        foreach ($databases as $db) {
            if ($db === 'php_course') {
                $projects[] = 'root';
            } elseif (strpos($db, 'php_course_') === 0) {
                $projects[] = substr($db, 11); // Remove 'php_course_' prefix
            }
        }
        
        return $projects;
    } catch (Exception $e) {
        return ['root']; // Fallback - only root database exists initially
    }
}

/**
 * Create a new project database
 * @param string $project_name Name of the new project
 * @return bool Success status
 */
function createProjectDatabase($project_name) {
    try {
        $pdo = new PDO("mysql:host=mysql", 'root', 'studentpass');
        $dbname = "php_course_{$project_name}";
        
        // Create database
        $stmt = $pdo->prepare("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $stmt->execute();
        
        // Grant permissions
        $stmt = $pdo->prepare("GRANT ALL PRIVILEGES ON `{$dbname}`.* TO 'student'@'%'");
        $stmt->execute();
        
        $pdo->exec("FLUSH PRIVILEGES");
        
        return true;
    } catch (Exception $e) {
        error_log("Failed to create database for project '{$project_name}': " . $e->getMessage());
        return false;
    }
}
?>