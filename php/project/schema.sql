-- Final Project Database Schema
-- Students: Design your complete database schema here
-- This file will be executed whenever you reset your Final Project database

-- Project information table
CREATE TABLE project_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100),
    project_title VARCHAR(200),
    description TEXT,
    start_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data for project info
INSERT INTO project_info (student_name, project_title, description, start_date) 
VALUES ('Student Name', 'My DMIT2025 Final Project', 'Description of the comprehensive web application', CURDATE());

-- Example comprehensive tables for a typical web application project
-- Users management
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Content/Posts management
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories for content organization
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Many-to-many relationship between posts and categories
CREATE TABLE post_categories (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Comments system
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample data for testing
INSERT INTO users (username, email, password_hash, full_name, role) VALUES 
    ('admin', 'admin@example.com', '$2y$10$example_hash_here', 'System Administrator', 'admin'),
    ('student', 'student@example.com', '$2y$10$example_hash_here', 'Test Student', 'user');

INSERT INTO categories (name, description) VALUES 
    ('General', 'General posts and announcements'),
    ('Tutorial', 'How-to guides and tutorials'),
    ('News', 'Latest news and updates');

INSERT INTO posts (user_id, title, content, status, published_at) VALUES 
    (1, 'Welcome to the Project', 'This is the first post in your final project!', 'published', NOW()),
    (1, 'Getting Started', 'Here are some tips for building your web application.', 'published', NOW());