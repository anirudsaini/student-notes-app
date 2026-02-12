-- =========================================
-- Coaching Resource Hub - Full Database
-- =========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS coaching_resource_hub;
USE coaching_resource_hub;

-- =========================================
-- USERS TABLE
-- =========================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- ADMIN TABLE
-- =========================================
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- NOTES TABLE
-- =========================================
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    file VARCHAR(255) NOT NULL,
    file_size VARCHAR(20),
    downloads INT DEFAULT 0,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- DEFAULT ADMIN (Username: admin)
-- Password must be created via register page
-- =========================================
-- NOTE: Do NOT insert plain password manually
-- Use admin/register.php to create admin
