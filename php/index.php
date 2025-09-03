<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Development Environment - Project Dashboard</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #f5f5f5; 
        }
        .header { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-bottom: 20px; 
        }
        .projects-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 20px; 
        }
        .project-card { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            transition: transform 0.2s; 
        }
        .project-card:hover { 
            transform: translateY(-2px); 
        }
        .project-link { 
            display: inline-block; 
            background: #007cba; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            margin-top: 10px; 
        }
        .project-link:hover { 
            background: #005a87; 
        }
        .status { 
            display: inline-block; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: bold; 
        }
        .status.exists { 
            background: #d4edda; 
            color: #155724; 
        }
        .status.missing { 
            background: #f8d7da; 
            color: #721c24; 
        }
        .tools { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            margin-top: 20px; 
        }
        .tool-link { 
            display: inline-block; 
            margin: 5px 10px 5px 0; 
            padding: 8px 16px; 
            background: #28a745; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .tool-link:hover { 
            background: #218838; 
        }
        .info-box { 
            background: #d1ecf1; 
            border-left: 4px solid #17a2b8; 
            padding: 15px; 
            margin: 20px 0; 
            border-radius: 4px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 PHP Development Environment</h1>
        <p>Multi-project development environment running PHP <?php echo PHP_VERSION; ?> with MySQL</p>
        
        <div class="info-box">
            <strong>Getting Started:</strong> Create a new folder in the <code>php/</code> directory for each project. 
            Access your projects at <code>http://localhost:8080/[project-name]/</code>
        </div>
    </div>

    <h2>📁 Your Projects</h2>
    <div class="projects-grid">
        <?php
        require_once 'shared/database.php';
        
        // Define project order: sb first, labs in order, then project
        $project_order = ['sb', 'lab1', 'lab2', 'lab3', 'lab4', 'project'];
        
        // Scan for project directories
        $found_dirs = [];
        $php_dir = __DIR__;
        if ($handle = opendir($php_dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != "shared" && $entry != "vendor" && is_dir($php_dir . '/' . $entry)) {
                    $found_dirs[] = $entry;
                }
            }
            closedir($handle);
        }
        
        // Arrange projects in the desired order
        $project_dirs = [];
        foreach ($project_order as $project) {
            if (in_array($project, $found_dirs)) {
                $project_dirs[] = $project;
            }
        }
        // Add any unexpected projects at the end
        foreach ($found_dirs as $dir) {
            if (!in_array($dir, $project_dirs)) {
                $project_dirs[] = $dir;
            }
        }
        
        // Get available databases
        $available_databases = getAvailableProjects();
        
        // Display existing projects in order
        foreach ($project_dirs as $project) {
            $has_index = file_exists($php_dir . '/' . $project . '/index.php');
            $has_database = in_array($project, $available_databases);
            
            // Set project-specific icons and titles
            $project_info = [
                'sb' => ['icon' => '🏖️', 'title' => 'Sandbox - Playground & Exercises'],
                'lab1' => ['icon' => '🧪', 'title' => 'Lab 1'],
                'lab2' => ['icon' => '🧪', 'title' => 'Lab 2'],
                'lab3' => ['icon' => '🧪', 'title' => 'Lab 3'],
                'lab4' => ['icon' => '🧪', 'title' => 'Lab 4'],
                'project' => ['icon' => '🚀', 'title' => 'Final Project - Large Assignment']
            ];
            
            $icon = $project_info[$project]['icon'] ?? '📂';
            $title = $project_info[$project]['title'] ?? ucfirst($project);
            
            echo "<div class='project-card'>";
            echo "<h3>$icon " . htmlspecialchars($title) . "</h3>";
            echo "<p><strong>Status:</strong> ";
            echo $has_index ? "<span class='status exists'>Has index.php</span>" : "<span class='status missing'>No index.php</span>";
            echo " ";
            echo $has_database ? "<span class='status exists'>Database ready</span>" : "<span class='status missing'>No database</span>";
            echo "</p>";
            
            if ($has_index) {
                echo "<a href='" . htmlspecialchars($project) . "/' class='project-link'>🔗 Open Project</a>";
                echo " <a href='shared/database-maintenance.php?project=" . urlencode($project) . "' class='project-link' style='background: #28a745;'>🛠️ DB Maintenance</a>";
            } else {
                echo "<p style='color: #666;'>Create an index.php file in the " . htmlspecialchars($project) . "/ folder to get started.</p>";
            }
            echo "</div>";
        }
        
        // Show message if no projects exist
        if (empty($project_dirs)) {
            echo "<div class='project-card'>";
            echo "<h3>🎯 Ready to start your first project?</h3>";
            echo "<p>Create a new folder in the <code>php/</code> directory and add an <code>index.php</code> file to get started.</p>";
            echo "<p>Example: <code>php/lab1/index.php</code> will be accessible at <code>http://localhost:8080/lab1/</code></p>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="tools">
        <h2>🛠️ Development Tools</h2>
        <a href="http://localhost:8081" target="_blank" class="tool-link">📊 phpMyAdmin</a>
        <a href="?phpinfo=1" class="tool-link">ℹ️ PHP Info</a>
        <a href="shared/test-db.php" class="tool-link">🔌 Test Database</a>
        <a href="shared/export-database.php" class="tool-link">📦 Export for Submission</a>
    </div>

    <div class="info-box">
        <strong>Database Info:</strong>
        <ul>
            <li>Databases are created <strong>on-demand</strong> - only when you need them for specific labs</li>
            <li>Each project gets its own isolated database: <code>php_course_[project-name]</code></li>
            <li>Click <strong>"Reset Database"</strong> in any project to create/recreate its database</li>
            <li>Use the shared database utility: <code>require_once '../shared/database.php';</code></li>
            <li>phpMyAdmin login: <strong>student</strong> / <strong>student</strong></li>
        </ul>
    </div>

    <?php if (isset($_GET['phpinfo'])): ?>
        <div style="margin-top: 40px; background: white; padding: 20px; border-radius: 10px;">
            <h2>PHP Configuration</h2>
            <?php phpinfo(); ?>
        </div>
    <?php endif; ?>
</body>
</html>