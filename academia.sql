-- BASE DE DATOS DEL PROYECTO: importa este archivo desde phpMyAdmin.
CREATE DATABASE IF NOT EXISTS academia
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE academia;

-- FORMULARIO DE CONTACTOS: registros recibidos desde contactos.html.
CREATE TABLE IF NOT EXISTS datos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    direccion VARCHAR(150) NOT NULL,
    correo VARCHAR(254) NOT NULL,
    comentarios TEXT NOT NULL,
    fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- USUARIOS DE DEMOSTRACIÓN: tabla usada por login.php.
CREATE TABLE IF NOT EXISTS academia (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

-- Cuenta local de ejemplo del tutorial; cambia la contraseña para uso propio.
INSERT INTO academia (usuario, password)
VALUES
    ('usuarioxy', '123456'),
    ('admin', '123456')
ON DUPLICATE KEY UPDATE password = VALUES(password);
