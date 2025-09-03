<?php
/**
 * Database Connection Test Utility
 * Tests database connections for all available projects
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .test-result { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
        .back-link { display: inline-block; margin: 20px 0; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; }
        .back-link:hover { background: #005a87; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🔌 Database Connection Test</h1>
    
    <a href="../" class="back-link">← Back to Dashboard</a>
    
    <?php
    require_once 'database.php';
    
    echo "<div class='info'><strong>Testing all database connections...</strong></div>";
    
    // Test root database
    echo "<h2>Main Database (php_course)</h2>";
    try {
        $pdo = getDatabase('root');
        echo "<div class='test-result success'>✅ Successfully connected to main database</div>";
        
        // Test query
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        echo "<div class='info'>Found {$result['count']} users in the users table</div>";
        
    } catch (Exception $e) {
        echo "<div class='test-result error'>❌ Failed to connect to main database: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    
    // Test project databases
    echo "<h2>Project Databases</h2>";
    $projects = getAvailableProjects();
    
    if (empty($projects) || (count($projects) == 1 && $projects[0] == 'root')) {
        echo "<div class='info'>No project databases found. Create a project folder to automatically get a dedicated database.</div>";
    } else {
        echo "<table>";
        echo "<thead><tr><th>Project Name</th><th>Database Name</th><th>Status</th><th>Details</th></tr></thead>";
        echo "<tbody>";
        
        foreach ($projects as $project) {
            if ($project === 'root') continue; // Already tested above
            
            $db_name = "php_course_{$project}";
            echo "<tr>";
            echo "<td>" . htmlspecialchars($project) . "</td>";
            echo "<td><code>" . htmlspecialchars($db_name) . "</code></td>";
            
            try {
                $pdo = getDatabase($project);
                echo "<td class='status-ok'>Connected</td>";
                
                // Get table count
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $table_count = count($tables);
                
                if ($table_count > 0) {
                    echo "<td>{$table_count} tables: " . implode(', ', $tables) . "</td>";
                } else {
                    echo "<td>Empty database - ready for your tables</td>";
                }
                
            } catch (Exception $e) {
                echo "<td class='status-error'>Failed</td>";
                echo "<td>" . htmlspecialchars($e->getMessage()) . "</td>";
            }
            
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    }
    
    // Connection parameters info
    echo "<h2>📋 Connection Information</h2>";
    echo "<div class='info'>";
    echo "<strong>Database Connection Parameters:</strong><br>";
    echo "Host: <code>mysql</code> (from PHP containers) or <code>localhost</code> (external)<br>";
    echo "Username: <code>student</code><br>";
    echo "Password: <code>student</code><br>";
    echo "Root Password: <code>studentpass</code><br>";
    echo "<br>";
    echo "<strong>Database Naming Convention:</strong><br>";
    echo "• Main database: <code>php_course</code><br>";
    echo "• Project databases: <code>php_course_[project-name]</code><br>";
    echo "</div>";
    
    // Auto-detection info
    echo "<h2>🔍 Auto-Detection Test</h2>";
    $current_project = getCurrentProjectName();
    echo "<div class='info'>";
    echo "<strong>Current Project Detection:</strong><br>";
    echo "Detected project name: <code>" . htmlspecialchars($current_project) . "</code><br>";
    echo "Would use database: <code>" . ($current_project === 'root' ? 'php_course' : "php_course_{$current_project}") . "</code>";
    echo "</div>";
    ?>
    
    <div class="info" style="margin-top: 30px;">
        <strong>💡 Usage Tips:</strong>
        <ul>
            <li>Include the database utility in your projects: <code>require_once '../shared/database.php';</code></li>
            <li>Get a connection: <code>$pdo = getDatabase();</code> (auto-detects project)</li>
            <li>Or specify a project: <code>$pdo = getDatabase('lab1');</code></li>
            <li>Each project gets its own isolated database</li>
            <li>Databases are created automatically when you first access them</li>
        </ul>
    </div>
    
    <a href="../" class="back-link">← Back to Dashboard</a>
</body>
</html>