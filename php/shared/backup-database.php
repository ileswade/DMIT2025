<?php
/**
 * Simple Database Backup Script
 * 
 * Students run this from their project folder:
 * php ../../backup-database.php
 * 
 * Automatically detects project from current directory and exports database
 */

// Determine project name from current directory
function getProjectName() {
    $current_dir = basename(getcwd());
    
    // If we're in the main directory, ask for project name
    if ($current_dir === 'sample' || $current_dir === 'php') {
        echo "❌ Please run this script from inside your project folder.\n";
        echo "Example: cd php/lab1 && php ../../backup-database.php\n";
        exit(1);
    }
    
    return $current_dir;
}

// Include database utility
require_once __DIR__ . '/database.php';

/**
 * Export database structure and data as SQL
 */
function exportProjectDatabase($project_name, $include_data = true) {
    try {
        $pdo = getDatabase($project_name);
        $db_name = $project_name === 'root' ? 'php_course' : "php_course_{$project_name}";
        
        $export = "-- Database Export for Project: {$project_name}\n";
        $export .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
        $export .= "-- Database: {$db_name}\n";
        $export .= "-- Use this file to recreate your database for submission\n\n";
        
        $export .= "-- Create database (if not exists)\n";
        $export .= "CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $export .= "USE `{$db_name}`;\n\n";
        
        // Get all tables
        $tables_stmt = $pdo->query("SHOW TABLES");
        $tables = $tables_stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($tables)) {
            $export .= "-- No tables found in database\n";
            $export .= "-- Your project database exists but is empty\n";
            return $export;
        }
        
        foreach ($tables as $table) {
            $export .= exportTable($pdo, $table, $include_data);
        }
        
        return $export;
        
    } catch (Exception $e) {
        throw new Exception("Database export failed: " . $e->getMessage());
    }
}

/**
 * Export a single table
 */
function exportTable($pdo, $table, $include_data = true) {
    $export = "-- --------------------------------------------------------\n";
    $export .= "-- Table structure for `{$table}`\n";
    $export .= "-- --------------------------------------------------------\n\n";
    
    // Drop table statement
    $export .= "DROP TABLE IF EXISTS `{$table}`;\n\n";
    
    // Create table statement
    $create_stmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
    $create_row = $create_stmt->fetch(PDO::FETCH_ASSOC);
    $export .= $create_row['Create Table'] . ";\n\n";
    
    if ($include_data) {
        // Get data count
        $count_stmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
        $count = $count_stmt->fetchColumn();
        
        if ($count > 0) {
            $export .= "-- Dumping data for table `{$table}` ({$count} records)\n";
            
            // Get all data
            $data_stmt = $pdo->query("SELECT * FROM `{$table}`");
            $rows = $data_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($rows)) {
                $columns = array_keys($rows[0]);
                $export .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES\n";
                
                $values = [];
                foreach ($rows as $row) {
                    $row_values = [];
                    foreach ($row as $value) {
                        if ($value === null) {
                            $row_values[] = 'NULL';
                        } else {
                            $row_values[] = "'" . addslashes($value) . "'";
                        }
                    }
                    $values[] = "(" . implode(', ', $row_values) . ")";
                }
                
                $export .= implode(",\n", $values) . ";\n\n";
            }
        } else {
            $export .= "-- No data in table `{$table}`\n\n";
        }
    }
    
    return $export;
}

// Main script execution
echo "🔄 PHP Project Database Backup Tool\n";
echo "=====================================\n\n";

try {
    // Get project name from current directory
    $project_name = getProjectName();
    echo "📂 Project detected: {$project_name}\n";
    
    // Check if database exists
    try {
        $pdo = getDatabase($project_name);
        $db_name = $project_name === 'root' ? 'php_course' : "php_course_{$project_name}";
        echo "🔌 Connected to database: {$db_name}\n";
    } catch (Exception $e) {
        echo "❌ Cannot connect to database for project '{$project_name}'\n";
        echo "   Make sure your Docker containers are running: docker compose up -d\n";
        echo "   Error: " . $e->getMessage() . "\n";
        exit(1);
    }
    
    // Generate export
    echo "📦 Exporting database...\n";
    $sql_export = exportProjectDatabase($project_name, true);
    
    // Save to current directory
    $filename = "database-backup-{$project_name}.sql";
    $result = file_put_contents($filename, $sql_export);
    
    if ($result === false) {
        echo "❌ Failed to save backup file\n";
        exit(1);
    }
    
    echo "✅ Database backup completed!\n";
    echo "📄 Saved as: {$filename}\n";
    echo "📏 File size: " . number_format(strlen($sql_export)) . " characters\n\n";
    
    // Show what was exported
    $lines = explode("\n", $sql_export);
    $table_count = 0;
    $data_lines = 0;
    foreach ($lines as $line) {
        if (strpos($line, 'CREATE TABLE') === 0) {
            $table_count++;
        }
        if (strpos($line, 'INSERT INTO') === 0) {
            $data_lines++;
        }
    }
    
    echo "📊 Export contains:\n";
    echo "   - {$table_count} table(s)\n";
    echo "   - {$data_lines} data insert statement(s)\n\n";
    
    echo "🎯 NEXT STEPS:\n";
    echo "   1. This file ({$filename}) is now in your project folder\n";
    echo "   2. Include this file when you zip your project for submission\n";
    echo "   3. Your instructor can import this file to recreate your database\n\n";
    
    echo "✨ Ready for submission! Your database is backed up.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Troubleshooting:\n";
    echo "   - Make sure Docker is running: docker compose up -d\n";
    echo "   - Run this script from your project folder (e.g., php/lab1/)\n";
    echo "   - Check that your project database exists\n";
    exit(1);
}
?>