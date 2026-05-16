CREATE DATABASE IF NOT EXISTS clientes_db;
USE clientes_db;

CREATE TABLE IF NOT EXISTS clientes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(150) NOT NULL,
    telefono        VARCHAR(50),
    correo          VARCHAR(100),
    numero_licencia VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO clientes (nombre, telefono, correo, numero_licencia) VALUES
('Carlos Mendoza', '310-555-0101', 'carlos@ejemplo.com', 'LIC-001'),
('Ana Rodríguez',  '320-555-0202', 'ana@ejemplo.com',    'LIC-002');
