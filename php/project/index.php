<?php
/**
 * Final Project - Large Assignment
 * Students will build their comprehensive web application here
 */

require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project - Large Assignment</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #e7f3ff; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .warning { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .back-link { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .back-link:hover { background: #005a87; }
        .project-link { background: #28a745; }
        .project-link:hover { background: #218838; }
        h1 { color: #333; border-bottom: 3px solid #007cba; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Final Project - Large Assignment</h1>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <div class="warning">
            <strong>⚠️ Important - Large Assignment Space</strong><br>
            This is your dedicated workspace for the comprehensive final project. 
            You'll have plenty of space for multiple PHP files, complex database structures, and all project assets.
        </div>

        <h2>Database Connection Test</h2>
        <?php
        try {
            // Auto-connects to php_course_project database
            $pdo = getDatabase();
            echo "<div class='success'>✅ Connected to database: php_course_project</div>";
            
            // Example project table - students will create their own schema
            $pdo->exec("CREATE TABLE IF NOT EXISTS project_info (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_name VARCHAR(100),
                project_title VARCHAR(200),
                description TEXT,
                start_date DATE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
            // Check if project info exists
            $stmt = $pdo->query("SELECT COUNT(*) FROM project_info");
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $pdo->exec("INSERT INTO project_info (student_name, project_title, description, start_date) 
                          VALUES ('Student Name', 'My DMIT2025 Project', 'Description of the comprehensive web application', CURDATE())");
                echo "<div class='info'>📝 Project database initialized with example structure.</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            
            // Show database setup option when connection fails
            echo "<div class='warning'>";
            echo "<strong>🔧 Database Setup Required</strong><br>";
            echo "Your Final Project database needs to be created. Click below to set up your isolated database.<br><br>";
            echo "<a href='../shared/database-maintenance.php?project=project' class='back-link' style='background: #28a745;'>⚙️ Database Maintenance</a>";
            echo "</div>";
        }
        ?>
        
        <h2>🎯 Project Workspace</h2>
        <div class="info">
            <strong>This dedicated project space includes:</strong>
            <ul>
                <li>✅ Isolated database: <code>php_course_project</code></li>
                <li>✅ Full PHP development environment</li>
                <li>✅ Unlimited file structure flexibility</li>
                <li>✅ Complete database backup/restore for submission</li>
            </ul>
        </div>

        <h2>📋 Project Development Guidelines</h2>
        <div class="info">
            <strong>Recommended file organization:</strong>
            <ul>
                <li><code>index.php</code> - Main landing page</li>
                <li><code>admin/</code> - Administrative pages</li>
                <li><code>includes/</code> - Shared functions and includes</li>
                <li><code>css/</code> - Stylesheets</li>
                <li><code>js/</code> - JavaScript files</li>
                <li><code>images/</code> - Project images</li>
            </ul>
        </div>

        <h2>Project Access Details</h2>
        <ul>
            <li><strong>URL:</strong> <code>http://localhost:8080/project/</code></li>
            <li><strong>Database:</strong> <code>php_course_project</code></li>
            <li><strong>Folder:</strong> <code>php/project/</code></li>
        </ul>
        
        <h2>📦 Final Submission Process</h2>
        <div class="warning">
            <strong>When ready to submit your final project:</strong><br>
            1. <strong>Backup database:</strong> <code>php ../shared/backup-database.php</code> from this folder<br>
            2. <strong>Create submission zip:</strong> Include all project files + database backup<br>
            3. <strong>Submit as:</strong> <code>LastName_FirstName_FinalProject.zip</code><br>
            <br>
            <em>💡 Make sure to include ALL files: PHP, CSS, JS, images, and the database backup!</em>
        </div>

        <h2>🛠️ Development Tools</h2>
        <p>
            <a href="http://localhost:8081" target="_blank" class="back-link project-link">📊 phpMyAdmin</a>
            <a href="../shared/test-db.php" class="back-link project-link">🔌 Test Database</a>
            <a href="../shared/database-maintenance.php?project=project" class="back-link" style="background: #28a745;">🛠️ DB Maintenance</a>
        </p>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>