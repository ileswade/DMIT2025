-- Lab 1 Database Schema
-- Students: Modify this file according to your Lab 1 requirements
-- This file will be executed whenever you reset your Lab 1 database

-- Example table structure for Lab 1
CREATE TABLE lab1_examples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert initial sample data
INSERT INTO lab1_examples (title, description) VALUES 
    ('Welcome Example', 'This is your first database entry!'),
    ('PHP Basics', 'Learn about variables, functions, and control structures'),
    ('Database Integration', 'Connect PHP with MySQL for dynamic websites');

-- Add more tables as needed for your Lab 1 requirements
-- CREATE TABLE your_table_name (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     column_name VARCHAR(100),
--     another_column TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );