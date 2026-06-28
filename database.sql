-- ============================================================
--  Student Management System  (ICT600 Web Technology)
--  Database setup script
-- ============================================================
--  Run with:  mysql -u root < database.sql
--  Or import via phpMyAdmin / HeidiSQL.
-- ============================================================

CREATE DATABASE IF NOT EXISTS STUDENTMGTDB
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE STUDENTMGTDB;

-- ------------------------------------------------------------
--  USER table  (login authentication + access role)
-- ------------------------------------------------------------
DROP TABLE IF EXISTS user;
CREATE TABLE user (
    user_id     INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,           
    full_name   VARCHAR(100) NOT NULL,
    role        ENUM('admin','student') NOT NULL DEFAULT 'student',
    photo       VARCHAR(255) DEFAULT NULL          
) ENGINE=InnoDB;

-- ------------------------------------------------------------
--  STUDENT table
-- ------------------------------------------------------------
DROP TABLE IF EXISTS student;
CREATE TABLE student (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    student_id  VARCHAR(20)  NOT NULL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    address1    VARCHAR(150) NOT NULL,
    address2    VARCHAR(150) DEFAULT NULL,
    postcode    VARCHAR(10)  NOT NULL,
    city        VARCHAR(60)  NOT NULL,
    gender      ENUM('Male','Female') NOT NULL,
    race        VARCHAR(40)  NOT NULL,
    religion    VARCHAR(40)  NOT NULL,
    contact     VARCHAR(20)  NOT NULL,
    email       VARCHAR(120) NOT NULL,
    photo       VARCHAR(255) DEFAULT NULL,        
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
--  Seed users  (passwords:  admin -> admin123 ,  student -> student123)
--  Hashes are bcrypt (password_hash, PASSWORD_DEFAULT).
-- ------------------------------------------------------------
INSERT INTO user (username, password, full_name, role) VALUES
('admin',   '$2y$10$MMCrgekXoeHc1bd1KglRpuaYWnTem2.qtv.MZVqJawvd0l1rR9F7e', 'System Administrator', 'admin'),
('student', '$2y$10$CLJqthH1cn9TrftAPpjPbeBxf7irU8Qeay0kdIwkYlpdP8TxXn22G', 'Demo Student',         'student');

-- ------------------------------------------------------------
--  Seed students  (1-2 records; bulk 500 added separately)
-- ------------------------------------------------------------
INSERT INTO student
(student_id, name, address1, address2, postcode, city, gender, race, religion, contact, email) VALUES
('2023111001', 'Ahmad Bin Ali', 'No 12 Jalan Mawar', 'Taman Seri', '40000', 'Shah Alam', 'Male',   'Malay',  'Islam',    '012-3456789', 'ahmad@example.com'),
('2023111002', 'Siti Nurhaliza', 'No 88 Jalan Melati', 'Taman Indah', '43000', 'Kajang',   'Female', 'Malay',  'Islam',    '019-8765432', 'siti@example.com');

-- ------------------------------------------------------------
--  Add STATE column to existing student table
-- ------------------------------------------------------------
ALTER TABLE student ADD COLUMN state VARCHAR(40) NOT NULL DEFAULT '' AFTER city;
