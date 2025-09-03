-- Create databases for different projects
CREATE DATABASE IF NOT EXISTS php_course DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS php_course_lab1 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS php_course_lab2 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS php_course_assignment1 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant permissions for student user on all project databases
GRANT ALL PRIVILEGES ON php_course.* TO 'student'@'%';
GRANT ALL PRIVILEGES ON php_course_lab1.* TO 'student'@'%';
GRANT ALL PRIVILEGES ON php_course_lab2.* TO 'student'@'%';
GRANT ALL PRIVILEGES ON php_course_assignment1.* TO 'student'@'%';
FLUSH PRIVILEGES;

-- Example table in default database
USE php_course;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add sample data
INSERT INTO users (username, email) VALUES 
    ('john_doe', 'john@example.com'),
    ('jane_smith', 'jane@example.com');

-- Example table for lab1 (students will modify this for their projects)
USE php_course_lab1;
CREATE TABLE example_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO example_table (name) VALUES ('Lab 1 Example Data');