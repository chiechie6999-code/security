CREATE DATABASE  ccmart;

USE ccmart;

CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_number VARCHAR(9) NOT NULL UNIQUE,
    firstname VARCHAR(255) NOT NULL,
    middlename VARCHAR(255),
    familyname VARCHAR(255) NOT NULL,
    extension VARCHAR(255),
    suffix VARCHAR(255),
    birthdate DATE NOT NULL,
    age INT(3) NOT NULL,
    purok_street VARCHAR(255) NOT NULL,
    barangay VARCHAR(255) NOT NULL,
    municipal_city VARCHAR(255) NOT NULL,
    province VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    auth_q1 VARCHAR(255) NOT NULL,
    auth_a1 VARCHAR(255) NOT NULL,
    auth_q2 VARCHAR(255) NOT NULL,
    auth_a2 VARCHAR(255) NOT NULL,
    auth_q3 VARCHAR(255) NOT NULL,
    auth_a3 VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
