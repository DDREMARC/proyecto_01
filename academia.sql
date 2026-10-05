-- BASE DE DATOS DEL PROYECTO: importa este archivo desde phpMyAdmin.
CREATE DATABASE IF NOT EXISTS academia
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE academia;

-- FORMULARIO DE CONTACTOS: registros recibidos desde contactos.html.
CREATE TABLE IF NOT EXISTS datos (
    nombres VARCHAR(30) NOT NULL,
    direccion VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    comentarios TEXT NOT NULL
);

-- USUARIOS DE DEMOSTRACIÓN: tabla usada por login.php.
CREATE TABLE IF NOT EXISTS academia (
    usuario VARCHAR(30) NOT NULL PRIMARY KEY,
    password VARCHAR(30) NOT NULL
);

-- Cuenta local de ejemplo del tutorial; cambia la contraseña para uso propio.
INSERT INTO academia (usuario, password)
VALUES
    ('usuarioxy', '123456'),
    ('admin', '123456')
ON DUPLICATE KEY UPDATE password = VALUES(password);
