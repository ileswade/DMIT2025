<?php
/**
 * Sandbox - Playground for Learning
 * Perfect for exercises, walkthroughs, testing concepts, and experimentation
 */

require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandbox - PHP/MySQL Playground</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #e7f3ff; color: #0c5460; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .playground { background: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .back-link { display: inline-block; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .back-link:hover { background: #005a87; }
        .sandbox-link { background: #fd7e14; }
        .sandbox-link:hover { background: #e8590c; }
        h1 { color: #333; }
        .emoji { font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏖️ Sandbox - Your PHP/MySQL Playground</h1>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <div class="playground">
            <strong>🎪 Welcome to the Sandbox!</strong><br>
            This is your safe space for experimentation, exercises, walkthroughs, and testing new concepts. 
            Break things, try stuff out, and learn without fear!
        </div>

        <h2>🔌 Database Connection Test</h2>
        <?php
        try {
            // Auto-connects to php_course_sb database
            $pdo = getDatabase();
            echo "<div class='success'>✅ Connected to database: php_course_sb</div>";
            
            // Create a playground table for testing
            $pdo->exec("CREATE TABLE IF NOT EXISTS sandbox_experiments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                experiment_name VARCHAR(100),
                code_snippet TEXT,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
            
            // Add a welcome experiment if table is empty
            $stmt = $pdo->query("SELECT COUNT(*) FROM sandbox_experiments");
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $pdo->exec("INSERT INTO sandbox_experiments (experiment_name, code_snippet, notes) VALUES 
                    ('Welcome Test', '<?php echo \"Hello Sandbox!\"; ?>', 'First experiment in the sandbox - everything is working!'),
                    ('Database Connection', 'PDO connection test', 'Testing database connectivity and basic operations')");
                echo "<div class='info'>🧪 Sandbox initialized with example experiments!</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
            
            // Show database setup option when connection fails
            echo "<div class='playground'>";
            echo "<strong>🔧 Database Setup Required</strong><br>";
            echo "It looks like your sandbox database needs to be set up. Click the button below to create your isolated database.<br><br>";
            echo "<a href='../shared/database-maintenance.php?project=sb' class='back-link sandbox-link'>⚙️ Database Maintenance</a>";
            echo "</div>";
        }
        ?>

        <h2>🎯 Perfect for...</h2>
        <div class="info">
            <ul>
                <li><span class="emoji">📚</span> <strong>Class Exercises</strong> - Follow along with instructor examples</li>
                <li><span class="emoji">🚶‍♂️</span> <strong>Walkthroughs</strong> - Step-by-step tutorials and guides</li>
                <li><span class="emoji">🧪</span> <strong>Experiments</strong> - Test PHP syntax, MySQL queries, new concepts</li>
                <li><span class="emoji">💡</span> <strong>Quick Tests</strong> - Try something without setting up a new project</li>
                <li><span class="emoji">🔧</span> <strong>Debugging</strong> - Isolate problems and test solutions</li>
                <li><span class="emoji">🎨</span> <strong>Prototyping</strong> - Rough drafts before lab work</li>
            </ul>
        </div>

        <h2>📋 Sandbox Details</h2>
        <ul>
            <li><strong>URL:</strong> <code>http://localhost:8080/sb/</code> (super easy!)</li>
            <li><strong>Database:</strong> <code>php_course_sb</code></li>
            <li><strong>Folder:</strong> <code>php/sb/</code></li>
        </ul>
        
        <div class="playground">
            <strong>🚀 Getting Started:</strong><br>
            1. Create any PHP files you want: <code>test.php</code>, <code>experiment1.php</code>, etc.<br>
            2. Access them at: <code>http://localhost:8080/sb/test.php</code><br>
            3. Use the database for testing: <code>$pdo = getDatabase();</code><br>
            4. Don't worry about breaking things - this is your playground!
        </div>

        <h2>🛠️ Quick Tools</h2>
        <div>
            <a href="http://localhost:8081" target="_blank" class="back-link sandbox-link">📊 phpMyAdmin</a>
            <a href="../shared/test-db.php" class="back-link sandbox-link">🔌 Test Database</a>
            <a href="../shared/database-maintenance.php?project=sb" class="back-link" style="background: #28a745;">🛠️ DB Maintenance</a>
        </div>

        <div class="info">
            <strong>💡 Pro Tips:</strong><br>
            • Use this space to practice before working on labs<br>
            • Test complex queries here before adding to your projects<br>
            • Perfect for "what if..." experiments<br>
            • No submission needed - this is just for learning!
        </div>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>