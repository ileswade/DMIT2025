<?php
/**
 * Lab 4 - Student Project
 * Replace this template with your Lab 4 requirements
 */

require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 4 - Student Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #e7f3ff; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .back-link { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .back-link:hover { background: #005a87; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Lab 4 - Ready for Student Work</h1>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <div class="info">
            <strong>Lab 4 Environment Ready!</strong><br>
            This project has its own isolated database and workspace.
        </div>

        <h2>Database Connection Test</h2>
        <?php
        try {
            // Auto-connects to php_course_lab4 database
            $pdo = getDatabase();
            echo "<div class='success'>✅ Connected to database: php_course_lab4</div>";
            
            // Students will replace this with their Lab 4 table structure
            $pdo->exec("CREATE TABLE IF NOT EXISTS lab4_work (
                id INT AUTO_INCREMENT PRIMARY KEY,
                project_name VARCHAR(100),
                status VARCHAR(50),
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
            echo "<div class='info'>📝 Lab 4 database table created and ready for your work.</div>";
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            
            // Show database setup option when connection fails
            echo "<div class='info'>";
            echo "<strong>🔧 Database Setup Required</strong><br>";
            echo "Your Lab 4 database needs to be created. Click below to set up your isolated database.<br><br>";
            echo "<a href='../shared/database-maintenance.php?project=lab4' class='back-link' style='background: #28a745;'>⚙️ Database Maintenance</a>";
            echo "</div>";
        }
        ?>
        
        <h2>Project Details</h2>
        <ul>
            <li><strong>URL:</strong> <code>http://localhost:8080/lab4/</code></li>
            <li><strong>Database:</strong> <code>php_course_lab4</code></li>
            <li><strong>Folder:</strong> <code>php/lab4/</code></li>
        </ul>
        
        <h2>🛠️ Development Tools</h2>
        <p>
            <a href="http://localhost:8081" target="_blank" class="back-link">📈 phpMyAdmin</a>
            <a href="../shared/test-db.php" class="back-link">🔌 Test Databases</a>
            <a href="../shared/database-maintenance.php?project=lab4" class="back-link" style="background: #28a745;">🛠️ DB Maintenance</a>
        </p>

        <div class="info">
            <strong>When ready to submit:</strong><br>
            1. From this folder: <code>php ../shared/backup-database.php</code><br>
            2. Zip this entire lab4 folder<br>
            3. Submit: <code>LastName_FirstName_Lab4.zip</code>
        </div>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>