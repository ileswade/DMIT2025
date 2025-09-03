<?php
/**
 * Simple Database Creation Script
 * 
 * Students run this from their project folder:
 * php ../../create-database.php
 * 
 * Automatically detects project from current directory and creates database + connection example
 */

// Determine project name from current directory
function getProjectName() {
    $current_dir = basename(getcwd());
    
    // If we're in the main directory, ask for project name
    if ($current_dir === 'sample' || $current_dir === 'php') {
        echo "❌ Please run this script from inside your project folder.\n";
        echo "Example: cd php/lab1 && php ../../create-database.php\n";
        exit(1);
    }
    
    return $current_dir;
}

// Include database utility
require_once __DIR__ . '/database.php';

/**
 * Create a sample connection file for the project
 */
function createConnectionExample($project_name) {
    $filename = "database-connection-example.php";
    
    $content = "<?php\n";
    $content .= "/**\n";
    $content .= " * Database Connection Example for {$project_name}\n";
    $content .= " * Generated on: " . date('Y-m-d H:i:s') . "\n";
    $content .= " */\n\n";
    
    $content .= "// EASY METHOD (RECOMMENDED)\n";
    $content .= "// This automatically connects to your project's database\n";
    $content .= "require_once '../shared/database.php';\n\n";
    
    $content .= "try {\n";
    $content .= "    // Auto-detects this is '{$project_name}' and connects to 'php_course_{$project_name}'\n";
    $content .= "    \$pdo = getDatabase();\n";
    $content .= "    echo \"✅ Connected to your project database!\";\n\n";
    
    $content .= "    // Example: Create a table\n";
    $content .= "    \$sql = \"CREATE TABLE IF NOT EXISTS example_table (\n";
    $content .= "        id INT AUTO_INCREMENT PRIMARY KEY,\n";
    $content .= "        name VARCHAR(100) NOT NULL,\n";
    $content .= "        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n";
    $content .= "    )\";\n";
    $content .= "    \$pdo->exec(\$sql);\n\n";
    
    $content .= "    // Example: Insert data\n";
    $content .= "    \$stmt = \$pdo->prepare(\"INSERT INTO example_table (name) VALUES (?)\");\n";
    $content .= "    \$stmt->execute(['{$project_name} example data']);\n\n";
    
    $content .= "    // Example: Select data\n";
    $content .= "    \$stmt = \$pdo->query(\"SELECT * FROM example_table\");\n";
    $content .= "    \$rows = \$stmt->fetchAll(PDO::FETCH_ASSOC);\n";
    $content .= "    foreach (\$rows as \$row) {\n";
    $content .= "        echo \"<br>ID: \" . \$row['id'] . \", Name: \" . \$row['name'];\n";
    $content .= "    }\n\n";
    
    $content .= "} catch (Exception \$e) {\n";
    $content .= "    echo \"❌ Database error: \" . \$e->getMessage();\n";
    $content .= "}\n\n";
    
    $content .= "// MANUAL METHOD (ADVANCED)\n";
    $content .= "// If you need to connect manually:\n";
    $content .= "/*\n";
    $content .= "\$host = 'mysql';  // Docker service name\n";
    $content .= "\$dbname = 'php_course_{$project_name}';  // Your specific database\n";
    $content .= "\$username = 'student';\n";
    $content .= "\$password = 'student';\n\n";
    
    $content .= "try {\n";
    $content .= "    \$pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname;charset=utf8mb4\", \$username, \$password);\n";
    $content .= "    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n";
    $content .= "    echo \"Connected successfully\";\n";
    $content .= "} catch(PDOException \$e) {\n";
    $content .= "    echo \"Connection failed: \" . \$e->getMessage();\n";
    $content .= "}\n";
    $content .= "*/\n";
    $content .= "?>\n";
    
    return file_put_contents($filename, $content);
}

// Main script execution
echo "🛠️  PHP Project Database Setup Tool\n";
echo "====================================\n\n";

try {
    // Get project name from current directory
    $project_name = getProjectName();
    echo "📂 Project detected: {$project_name}\n";
    
    $db_name = $project_name === 'root' ? 'php_course' : "php_course_{$project_name}";
    echo "🎯 Target database: {$db_name}\n\n";
    
    // Check if database already exists and is accessible
    echo "🔍 Checking database status...\n";
    try {
        $pdo = getDatabase($project_name);
        echo "✅ Database already exists and is accessible!\n";
        
        // Check if it has any tables
        $tables_stmt = $pdo->query("SHOW TABLES");
        $tables = $tables_stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($tables)) {
            echo "📝 Database is empty - ready for your tables\n";
        } else {
            echo "📊 Database contains " . count($tables) . " table(s): " . implode(', ', $tables) . "\n";
        }
        
    } catch (Exception $e) {
        echo "⚠️  Database not accessible, attempting to create...\n";
        
        // Try to create the database
        try {
            // Connect as root to create database
            $root_pdo = new PDO("mysql:host=mysql", 'root', 'studentpass');
            
            // Create database
            $sql = "CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $root_pdo->exec($sql);
            
            // Grant permissions
            $sql = "GRANT ALL PRIVILEGES ON `{$db_name}`.* TO 'student'@'%'";
            $root_pdo->exec($sql);
            
            $root_pdo->exec("FLUSH PRIVILEGES");
            
            echo "✅ Database created successfully!\n";
            
            // Test the new database
            $pdo = getDatabase($project_name);
            echo "✅ Database connection verified!\n";
            
        } catch (Exception $create_error) {
            echo "❌ Failed to create database: " . $create_error->getMessage() . "\n";
            echo "\n💡 Make sure Docker containers are running: docker compose up -d\n";
            exit(1);
        }
    }
    
    // Create connection example file
    echo "\n📝 Creating database connection example...\n";
    $example_result = createConnectionExample($project_name);
    
    if ($example_result === false) {
        echo "⚠️  Could not create example file\n";
    } else {
        echo "✅ Created: database-connection-example.php\n";
    }
    
    echo "\n🎯 DATABASE SETUP COMPLETE!\n";
    echo "===========================\n\n";
    
    echo "✨ Your project database is ready:\n";
    echo "   📁 Project: {$project_name}\n";
    echo "   🗄️  Database: {$db_name}\n";
    echo "   🔗 Connection: Use the shared database helper\n\n";
    
    echo "📋 QUICK START:\n";
    echo "   1. In your PHP files, add: require_once '../shared/database.php';\n";
    echo "   2. Get connection with: \$pdo = getDatabase();\n";
    echo "   3. Create tables and work with your data!\n";
    echo "   4. See 'database-connection-example.php' for sample code\n\n";
    
    echo "🌐 TESTING:\n";
    echo "   • View your project: http://localhost:8080/{$project_name}/\n";
    echo "   • phpMyAdmin: http://localhost:8081/ (student/student)\n";
    echo "   • Test connections: http://localhost:8080/shared/test-db.php\n\n";
    
    echo "🚀 Ready to code!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\n💡 Troubleshooting:\n";
    echo "   - Make sure Docker is running: docker compose up -d\n";
    echo "   - Run this script from your project folder (e.g., php/lab1/)\n";
    echo "   - Check Docker status: docker compose ps\n";
    exit(1);
}
?>