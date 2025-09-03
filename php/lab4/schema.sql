-- Lab 4 Database Schema
-- Students: Replace this with your Lab 4 requirements
-- This file will be executed whenever you reset your Lab 4 database

-- Example table for Lab 4
CREATE TABLE lab4_work (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(100),
    status VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Initial data for Lab 4
INSERT INTO lab4_work (project_name, status, notes) VALUES 
    ('Sample Project', 'In Progress', 'This is example work for Lab 4'),
    ('Demo Assignment', 'Completed', 'Another example entry for Lab 4');

-- Add your Lab 4 specific tables here
-- Example for more advanced lab work:
-- CREATE TABLE user_sessions (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     user_id INT NOT NULL,
--     session_token VARCHAR(255) NOT NULL,
--     expires_at TIMESTAMP NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );
-- 
-- CREATE TABLE user_profiles (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     username VARCHAR(50) NOT NULL UNIQUE,
--     email VARCHAR(100) NOT NULL UNIQUE,
--     password_hash VARCHAR(255) NOT NULL,
--     full_name VARCHAR(100),
--     bio TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );