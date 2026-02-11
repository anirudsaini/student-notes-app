-- Create Database
CREATE DATABASE IF NOT EXISTS student_notes;
USE student_notes;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Admin Table (Secure Login ke liye)
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Notes Table
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    file VARCHAR(255) NOT NULL
);

-- Default Admin Insert (username: admin , password: admin123)
INSERT INTO admin (username, password)
VALUES ('admin', '$2y$10$wH6YVxkYbK4X8Z3Z8mYqUe9dWQm4kQ8ZpJt9R8lWmYpFZlZpJk2uS');
