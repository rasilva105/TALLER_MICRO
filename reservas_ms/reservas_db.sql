CREATE DATABASE IF NOT EXISTS reservas_db;
USE reservas_db;

CREATE TABLE IF NOT EXISTS reservas (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id   INT  NOT NULL,
    vehiculo_id  INT  NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin    DATE NOT NULL,
    estado       ENUM('activa','completada','cancelada') DEFAULT 'activa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO reservas (cliente_id, vehiculo_id, fecha_inicio, fecha_fin, estado) VALUES
(1, 2, '2025-05-01', '2025-05-07', 'activa');
