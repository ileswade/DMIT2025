<?php
/**
 * Lab 1 - Example Project
 * This demonstrates how to create a new project in the multi-project environment
 */

// Include the shared database utility
require_once '../shared/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1 - Student Example</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .success { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
        }
        .info { 
            background: #d1ecf1; 
            color: #0c5460; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        th, td { 
            padding: 12px; 
            border: 1px solid #ddd; 
            text-align: left; 
        }
        th { 
            background: #f8f9fa; 
            font-weight: bold; 
        }
        .back-link { 
            display: inline-block; 
            margin: 20px 0; 
            padding: 10px 20px; 
            background: #007cba; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .back-link:hover { 
            background: #005a87; 
        }
        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Monaco', 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Lab 1 - Example Project</h1>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
        
        <div class="info">
            <strong>Welcome to your first project!</strong><br>
            This is an example of how to set up a new project in the multi-project environment.
            Each project gets its own database and URL path.
        </div>

        <h2>🔌 Database Connection Test</h2>
        <?php
        try {
            // Get database connection (auto-detects this is 'lab1' project)
            $pdo = getDatabase();
            echo "<div class='success'>✅ Successfully connected to database: <strong>php_course_lab1</strong></div>";
            
            // Create an example table if it doesn't exist
            $sql = "CREATE TABLE IF NOT EXISTS lab1_examples (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
            
            // Insert some sample data if table is empty
            $count_stmt = $pdo->query("SELECT COUNT(*) FROM lab1_examples");
            $count = $count_stmt->fetchColumn();
            
            if ($count == 0) {
                $insert_sql = "INSERT INTO lab1_examples (title, description) VALUES 
                    ('Welcome Example', 'This is your first database entry!'),
                    ('PHP Basics', 'Learn about variables, functions, and control structures'),
                    ('Database Integration', 'Connect PHP with MySQL for dynamic websites')";
                $pdo->exec($insert_sql);
                echo "<div class='info'>📝 Created example table and inserted sample data</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>❌ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>

        <h2>📊 Sample Data Display</h2>
        <?php
        try {
            // Fetch and display data from our example table
            $stmt = $pdo->query("SELECT * FROM lab1_examples ORDER BY created_at DESC");
            $examples = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($examples)) {
                echo "<table>";
                echo "<thead><tr><th>ID</th><th>Title</th><th>Description</th><th>Created</th></tr></thead>";
                echo "<tbody>";
                
                foreach ($examples as $example) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($example['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($example['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($example['description']) . "</td>";
                    echo "<td>" . date('Y-m-d H:i', strtotime($example['created_at'])) . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='info'>No data found in the examples table.</div>";
            }
            
        } catch (Exception $e) {
            echo "<div class='error'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>

        <h2>💡 Project Information</h2>
        <div class="info">
            <strong>Project Details:</strong><br>
            • <strong>Project Name:</strong> lab1<br>
            • <strong>URL:</strong> <code>http://localhost:8080/lab1/</code><br>
            • <strong>Database:</strong> <code>php_course_lab1</code><br>
            • <strong>Folder:</strong> <code>php/lab1/</code><br>
            <br>
            <strong>Next Steps:</strong><br>
            1. Modify this <code>index.php</code> file for your lab requirements<br>
            2. Create additional PHP files as needed<br>
            3. Design your database tables<br>
            4. Initialize git: <code>git init</code> (optional)<br>
        </div>

        <h2>🛠️ Development Tools</h2>
        <p>
            <a href="http://localhost:8081" target="_blank" class="back-link">📊 phpMyAdmin</a>
            <a href="../shared/test-db.php" class="back-link">🔌 Test All Databases</a>
        </p>

        <div class="info">
            <strong>🎯 Ready to start coding?</strong><br>
            1. Open this file in your editor: <code>php/lab1/index.php</code><br>
            2. Replace this example code with your lab requirements<br>
            3. Create additional pages like <code>process.php</code>, <code>admin.php</code><br>
            4. Use the database helper: <code>$pdo = getDatabase();</code>
        </div>

        <h2>📦 Submission Tools</h2>
        <div class="info">
            <strong>When ready to submit:</strong><br>
            1. <strong>Backup your database:</strong> Run <code>php ../shared/backup-database.php</code> from this folder<br>
            2. <strong>Zip your project:</strong> Include all PHP files + the generated SQL backup file<br>
            3. <strong>Submit:</strong> Upload the zip file with both code and database<br>
            <br>
            <em>💡 The backup script automatically creates a SQL file with all your data!</em>
        </div>
        
        <a href="../" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>