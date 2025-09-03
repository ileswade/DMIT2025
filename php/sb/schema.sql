-- Sandbox Database Schema
-- This file defines the initial database structure for the Sandbox environment
-- Students can modify this file to customize their sandbox database

-- Create experiments table for tracking sandbox work
CREATE TABLE sandbox_experiments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    experiment_name VARCHAR(100) NOT NULL,
    code_snippet TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create a simple users table for practice
CREATE TABLE practice_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for experimentation (after all tables are created)
INSERT INTO sandbox_experiments (experiment_name, code_snippet, notes) VALUES 
    ('Welcome Test', '<?php echo "Hello Sandbox!"; ?>', 'First experiment in the sandbox - everything is working!'),
    ('Database Connection', 'PDO connection test', 'Testing database connectivity and basic operations'),
    ('PHP Basics', 'Variables and loops', 'Practicing PHP fundamentals');

-- Create a simple blog table for advanced exercises
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    author VARCHAR(100),
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO blog_posts (title, content, author) VALUES 
    ('Welcome to the Sandbox', 'This is your first blog post in the sandbox environment!', 'System'),
    ('PHP and MySQL', 'Learning to work with databases is fundamental to web development.', 'Instructor');

-- Insert sample users (after practice_users table is created)
INSERT INTO practice_users (username, email, full_name) VALUES 
    ('student1', 'student1@example.com', 'Test Student One'),
    ('student2', 'student2@example.com', 'Test Student Two'),
    ('admin', 'admin@example.com', 'Admin User');