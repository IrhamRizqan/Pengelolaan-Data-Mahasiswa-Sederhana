CREATE DATABASE IF NOT EXISTS db_mahasiswa
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE db_mahasiswa;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    jenis_kelamin VARCHAR(20) NOT NULL,
    prodi VARCHAR(100) NOT NULL
);

-- username: admin, password: admin123
INSERT INTO users (username, password)
VALUES ('admin', '$2y$12$n3R22XMEBLZWelmBCdoamuVsMucjEM93w2FMm0jhFu16DpiJesPiC')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO mahasiswa (nim, nama, email, jenis_kelamin, prodi)
VALUES
('10124055', 'Irham Rizqan', 'irham.10124055@mahasiswa.unikom.ac.id', 'Laki-laki', 'Teknik Informatika'),
('10124065', 'Fakhri Amrullah', 'fakhri.10124055@mahasiswa.unikom.ac.id', 'Laki-laki', 'Sistem Informasi')
ON DUPLICATE KEY UPDATE nim = VALUES(nim);