<?php
/**
 * Database Export Utility for Student Submissions
 * 
 * This utility exports a project's database as SQL scripts that can be included
 * in student submissions for grading.
 */

require_once 'database.php';

/**
 * Export database structure and data as SQL
 * @param string $project_name Name of the project to export
 * @param bool $include_data Whether to include data (true) or just structure (false)
 * @return string SQL export content
 */
function exportProjectDatabase($project_name, $include_data = true) {
    try {
        $pdo = getDatabase($project_name);
        $db_name = $project_name === 'root' ? 'php_course' : "php_course_{$project_name}";
        
        $export = "-- Database Export for Project: {$project_name}\n";
        $export .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
        $export .= "-- Database: {$db_name}\n\n";
        
        $export .= "-- Create database (if not exists)\n";
        $export .= "CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $export .= "USE `{$db_name}`;\n\n";
        
        // Get all tables
        $tables_stmt = $pdo->query("SHOW TABLES");
        $tables = $tables_stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($tables)) {
            $export .= "-- No tables found in database\n";
            return $export;
        }
        
        foreach ($tables as $table) {
            $export .= exportTable($pdo, $table, $include_data);
        }
        
        return $export;
        
    } catch (Exception $e) {
        throw new Exception("Export failed: " . $e->getMessage());
    }
}

/**
 * Export a single table structure and optionally data
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
            $export .= "-- --------------------------------------------------------\n";
            $export .= "-- Data for table `{$table}` ({$count} records)\n";
            $export .= "-- --------------------------------------------------------\n\n";
            
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

/**
 * Save export to file
 */
function saveExportToFile($project_name, $sql_content, $filename = null) {
    if ($filename === null) {
        $filename = "database-export-{$project_name}-" . date('Y-m-d-H-i-s') . ".sql";
    }
    
    $project_dir = __DIR__ . "/../{$project_name}";
    if (!is_dir($project_dir)) {
        mkdir($project_dir, 0755, true);
    }
    
    $filepath = $project_dir . "/" . $filename;
    $result = file_put_contents($filepath, $sql_content);
    
    if ($result === false) {
        throw new Exception("Failed to save export file");
    }
    
    return $filename;
}

// Handle web interface requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['project'])) {
    $project = $_GET['project'];
    $action = $_GET['action'] ?? 'view';
    $include_data = ($_GET['include_data'] ?? 'yes') === 'yes';
    
    header('Content-Type: text/html; charset=utf-8');
    
    try {
        $sql_export = exportProjectDatabase($project, $include_data);
        
        if ($action === 'download') {
            $filename = "database-export-{$project}-" . date('Y-m-d') . ".sql";
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($sql_export));
            echo $sql_export;
            exit;
        }
        
        if ($action === 'save') {
            $filename = saveExportToFile($project, $sql_export);
            $message = "✅ Database exported successfully! Saved as: <strong>{$filename}</strong>";
        }
        
    } catch (Exception $e) {
        $error = "❌ Export failed: " . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Export - Project Submission Tool</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .back-link, .btn { display: inline-block; margin: 10px 5px 10px 0; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #000; }
        .back-link:hover, .btn:hover { opacity: 0.8; }
        .export-preview { background: #f8f9fa; border: 1px solid #e9ecef; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto; font-family: Monaco, 'Courier New', monospace; font-size: 12px; white-space: pre-wrap; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, input[type="checkbox"] { margin: 5px 0; }
        .project-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin: 20px 0; }
        .project-card { background: #f8f9fa; border: 1px solid #e9ecef; padding: 15px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Database Export Tool</h1>
        <p>Export your project database for submission</p>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <?php if (isset($message)): ?>
            <div class="success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!isset($_GET['project'])): ?>
            <h2>Select Project to Export</h2>
            <div class="project-list">
                <?php
                $projects = getAvailableProjects();
                foreach ($projects as $project):
                ?>
                    <div class="project-card">
                        <h3><?php echo htmlspecialchars($project); ?></h3>
                        <a href="?project=<?php echo urlencode($project); ?>" class="btn">Export Database</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h2>Export Database for: <?php echo htmlspecialchars($project); ?></h2>
            
            <div class="info">
                <strong>📋 Submission Instructions:</strong><br>
                1. Choose your export options below<br>
                2. Save the SQL file to your project folder<br>
                3. Include this SQL file when you zip your project for submission<br>
                4. Your instructor can import this file to recreate your exact database
            </div>
            
            <form method="GET">
                <input type="hidden" name="project" value="<?php echo htmlspecialchars($project); ?>">
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="include_data" value="yes" <?php echo $include_data ? 'checked' : ''; ?>>
                        Include data in export (recommended for submissions)
                    </label>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="action" value="save" class="btn btn-success">💾 Save SQL File to Project</button>
                    <button type="submit" name="action" value="download" class="btn btn-warning">⬇️ Download SQL File</button>
                    <button type="submit" name="action" value="view" class="btn">👁️ Preview Export</button>
                </div>
            </form>
            
            <?php if (isset($sql_export) && $action === 'view'): ?>
                <h3>📄 Export Preview</h3>
                <div class="warning">
                    <strong>⚠️ Preview Only:</strong> This shows the first part of your export. Use "Save" or "Download" to get the complete file.
                </div>
                <div class="export-preview"><?php echo htmlspecialchars(substr($sql_export, 0, 2000)); ?><?php echo strlen($sql_export) > 2000 ? "\n\n... (truncated for preview)" : ""; ?></div>
            <?php endif; ?>
            
            <div class="info" style="margin-top: 30px;">
                <strong>💡 What gets exported:</strong><br>
                • Database structure (all tables, columns, indexes, etc.)<br>
                • Data from all tables (if "Include data" is checked)<br>
                • Proper SQL commands to recreate everything<br>
                • Compatible with MySQL/phpMyAdmin import
            </div>
        <?php endif; ?>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>