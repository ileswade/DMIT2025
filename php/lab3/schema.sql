-- Lab 3 Database Schema
-- Students: Replace this with your Lab 3 requirements
-- This file will be executed whenever you reset your Lab 3 database

-- Example table for Lab 3
CREATE TABLE lab3_work (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Initial data for Lab 3
INSERT INTO lab3_work (item_name, description) VALUES 
    ('Sample Item', 'This is an example item for Lab 3'),
    ('Test Entry', 'Another test entry for Lab 3 work');

-- Add your Lab 3 specific tables here
-- Example:
-- CREATE TABLE inventory (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     product_name VARCHAR(100) NOT NULL,
--     quantity INT DEFAULT 0,
--     unit_price DECIMAL(10,2),
--     category VARCHAR(50),
--     last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- );