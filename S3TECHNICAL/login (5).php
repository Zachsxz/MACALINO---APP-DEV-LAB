-- Run this in phpMyAdmin (SQL tab) or via mysql CLI
CREATE DATABASE IF NOT EXISTS sa3_db;
USE sa3_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    birthday VARCHAR(30),
    email VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20)
);
