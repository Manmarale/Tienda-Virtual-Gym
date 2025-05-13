CREATE DATABASE tienda_gym;
USE tienda_gym;


--Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

--Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    fecha_nacimiento DATE,
    genero VARCHAR(20)
);

--Tabla de productos (10 productos de gimnasio)
CREATE TABLE productos (
    referencia INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255)
);

-- Insertar productos de gimnasio
INSERT INTO productos (nombre, precio, descripcion) VALUES
('Mancuernas ajustables 20kg', 59.99, 'Mancuernas de hierro con sistema de ajuste rápido'),
('Barra olímpica 2.2m', 89.99, 'Barra para levantamiento de pesas profesional'),
('Banco de press ajustable', 129.99, 'Banco multifunción para ejercicios de pecho y abdominales'),
('Cinta de correr plegable', 349.99, 'Cinta de correr motorizada con 12 programas'),
('Kit de pesas rusas 3 piezas', 79.99, 'Set de kettlebells de 8kg, 12kg y 16kg'),
('Bandas de resistencia 5 piezas', 24.99, 'Set de bandas elásticas para entrenamiento'),
('Guantes de levantamiento', 19.99, 'Guantes acolchados para protección en el gym'),
('Chaleco lastrado 10kg', 49.99, 'Chaleco ajustable para entrenamiento con peso'),
('Rodillo de espuma', 14.99, 'Rodillo para liberación miofascial'),
('Botella shaker 750ml', 9.99, 'Botella mezcladora para proteínas y suplementos');

ALTER TABLE productos MODIFY imagen VARCHAR(255) NOT NULL;

UPDATE productos SET imagen = 'producto_' || referencia || '.jpg';