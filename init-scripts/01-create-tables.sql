-- DMIT2025 MySQL Server Initialization
-- Only creates the base environment - students create project databases as needed

-- Create default database for general MySQL access
CREATE DATABASE IF NOT EXISTS php_course DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant permissions to student user on all potential project databases
-- This allows the student user to create and manage their own project databases
GRANT CREATE, ALTER, DROP, SELECT, INSERT, UPDATE, DELETE, INDEX, CREATE TEMPORARY TABLES, LOCK TABLES ON *.* TO 'student'@'%';
FLUSH PRIVILEGES;

-- Example table in default database (for general testing/examples)
USE php_course;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add sample data for general examples
INSERT INTO users (username, email) VALUES 
    ('john_doe', 'john@example.com'),
    ('jane_smith', 'jane@example.com');