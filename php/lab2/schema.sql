-- Lab 2 Database Schema
-- Students: Replace this with your Lab 2 requirements
-- This file will be executed whenever you reset your Lab 2 database

-- Example table for Lab 2 work
CREATE TABLE lab2_work (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100),
    work_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data for Lab 2
INSERT INTO lab2_work (student_name, work_description) VALUES 
    ('Sample Student', 'This is example work for Lab 2'),
    ('Demo User', 'Another example entry for testing');

-- Add your Lab 2 specific tables here
-- Example:
-- CREATE TABLE products (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(100) NOT NULL,
--     price DECIMAL(10,2),
--     description TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );