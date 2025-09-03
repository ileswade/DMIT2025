<?php
/**
 * Lab 2 - Student Project Template
 * Students will replace this with their actual lab work
 */

// Include the shared database utility - auto-detects this is lab2
require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 2 - Student Project</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 20px; border-radius: 10px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; }
        .back-link { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lab 2 - Ready for Student Work</h1>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <h2>Database Connection</h2>
        <?php
        try {
            // This automatically connects to php_course_lab2 database
            $pdo = getDatabase();
            echo "<div class='success'>✅ Connected to database: php_course_lab2</div>";
            
            // Students will replace this with their actual table creation
            $pdo->exec("CREATE TABLE IF NOT EXISTS lab2_work (
                id INT AUTO_INCREMENT PRIMARY KEY,
                student_name VARCHAR(100),
                work_description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            
            // Show database setup option when connection fails
            echo "<div class='info'>";
            echo "<strong>🔧 Database Setup Required</strong><br>";
            echo "Your Lab 2 database needs to be created. Click below to set up your isolated database.<br><br>";
            echo "<a href='../shared/database-maintenance.php?project=lab2' class='back-link' style='background: #28a745;'>⚙️ Database Maintenance</a>";
            echo "</div>";
        }
        ?>
        
        <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <strong>Students:</strong> Replace this template with your Lab 2 requirements.<br>
            <strong>Database:</strong> Your work will be stored in the isolated <code>php_course_lab2</code> database.<br>
            <strong>Submission:</strong> Run <code>php ../shared/backup-database.php</code> from this folder when complete.
        </div>
        
        <p><strong>This project folder:</strong> <code>php/lab2/</code></p>
        <p><strong>URL:</strong> <code>http://localhost:8080/lab2/</code></p>
        
        <h2>🛠️ Development Tools</h2>
        <p>
            <a href="http://localhost:8081" target="_blank" class="back-link">📊 phpMyAdmin</a>
            <a href="../shared/test-db.php" class="back-link">🔌 Test Databases</a>
            <a href="../shared/database-maintenance.php?project=lab2" class="back-link" style="background: #28a745;">🛠️ DB Maintenance</a>
        </p>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>