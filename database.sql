-- TH4-2: Tạo database và bảng users
CREATE DATABASE IF NOT EXISTS th4_2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE th4_2;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm user mẫu (password: 123456)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
