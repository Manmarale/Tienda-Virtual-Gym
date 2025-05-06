-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS gimnasio_db;
USE gimnasio_db;

-- Tabla de usuarios (para autenticación)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'empleado') DEFAULT 'empleado',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    fecha_nacimiento DATE,
    genero ENUM('masculino', 'femenino', 'otro'),
    telefono VARCHAR(20),
    direccion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de productos
CREATE TABLE productos (
    referencia VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT,
    categoria ENUM('cardio', 'fuerza', 'accesorios', 'suplementos'),
    stock INT DEFAULT 0,
    imagen VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar datos de ejemplo en la tabla de productos
INSERT INTO productos (referencia, nombre, precio, descripcion, categoria, stock) VALUES
('PROD001', 'Mancuerna Ajustable 20kg', 89.99, 'Mancuerna ajustable de 2 a 20kg en incrementos de 1kg', 'fuerza', 15),
('PROD002', 'Cinta de Correr Plegable', 499.99, 'Cinta de correr con motor de 2.5HP, plegable para ahorrar espacio', 'cardio', 8),
('PROD003', 'Barra Olímpica', 129.99, 'Barra de levantamiento olímpico de 20kg, 2.2m de largo', 'fuerza', 12),
('PROD004', 'Banco de Pesas Ajustable', 149.99, 'Banco ajustable en 5 posiciones para press de banca y otros ejercicios', 'fuerza', 10),
('PROD005', 'Bicicleta Estática', 299.99, 'Bicicleta estática con 8 niveles de resistencia y monitor de seguimiento', 'cardio', 6),
('PROD006', 'Kit de Pesas Rusas', 199.99, 'Set de 3 pesas rusas (8kg, 12kg, 16kg) con estuche de almacenamiento', 'fuerza', 7),
('PROD007', 'Colchoneta de Yoga', 29.99, 'Colchoneta antideslizante de 1.5cm de grosor', 'accesorios', 25),
('PROD008', 'Proteína Whey 2kg', 49.99, 'Proteína de suero de leche con bajo contenido en azúcar', 'suplementos', 30),
('PROD009', 'Bandas de Resistencia', 24.99, 'Set de 5 bandas de resistencia con diferentes niveles', 'accesorios', 40),
('PROD010', 'Guantes de Gimnasio', 19.99, 'Guantes acolchados para levantamiento de pesas', 'accesorios', 20);

-- Crear tabla de pedidos (opcional para futuras funcionalidades)
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'procesando', 'enviado', 'entregado') DEFAULT 'pendiente',
    total DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Crear tabla de detalles de pedido (opcional)
CREATE TABLE detalles_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_referencia VARCHAR(20) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (producto_referencia) REFERENCES productos(referencia)
);