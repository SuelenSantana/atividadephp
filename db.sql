CREATE DATABASE IF NOT EXISTS vet_clinic;
USE vet_clinic;

CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(50),
    birth_date DATE,
    owner_name VARCHAR(100) NOT NULL,
    owner_phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE procedures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    procedure_name VARCHAR(100) NOT NULL,
    procedure_date DATE NOT NULL,
    description TEXT,
    veterinarian VARCHAR(100) NOT NULL,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
) ENGINE=InnoDB;