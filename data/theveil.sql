-- ===================================
-- BASE DE DATOS: theveil
-- Proyecto: The Veil - Atelier de Novias
-- Collation: utf8mb4_0900_ai_ci (MySQL 8.0+)
-- ===================================

-- 1. Crear la base de datos con collation correcto
DROP DATABASE IF EXISTS theveil;
CREATE DATABASE theveil 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_0900_ai_ci;
USE theveil;

-- 2. Tabla: admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_0900_ai_ci;

-- 3. Tabla: novias
CREATE TABLE novias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    ciudad VARCHAR(100),
    fecha_boda DATE,
    preferencias TEXT,
    acompanantes INT DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_0900_ai_ci;

-- 4. Tabla: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('vestido', 'accesorio') NOT NULL,
    silueta VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_0900_ai_ci;

-- 5. Tabla: appointments
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    novia_id INT,
    fecha_cita DATE NOT NULL,
    hora_cita TIME NOT NULL,
    servicio VARCHAR(50) NOT NULL,
    asesora_preferida VARCHAR(100),
    comentarios TEXT,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (novia_id) REFERENCES novias(id) ON DELETE SET NULL
) ENGINE=InnoDB 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_0900_ai_ci;

-- 6. Insertar administrador por defecto
INSERT INTO admins (email, password) VALUES (
    'admin@theveil.com',
    '$2y$10$K9dUZvQx1Y4ZzJqW8wXtOeGmHjNl6pRrT.sSsT7VvC3qY1Z2J0Pq'
);
-- Contraseña: admin123 (hash generado con password_hash)

-- 7. Insertar productos de ejemplo
INSERT INTO products (name, category, silueta, description, price, image) VALUES
('Vestido Clásico Diana', 'vestido', 'salón, clásico', 'Elegante vestido con encaje francés y cola corta.', 850.00, 'img/productos/vestido1.jpg'),
('Zapatos Stilettos Luna', 'accesorio', 'stilettos', 'Tacones altos con detalles dorados y punta abierta.', 150.00, 'img/productos/zapato1.jpg'),
('Velos Románticos Estela', 'accesorio', 'velo largo', 'Par de velos: corte bobo y largo hasta el suelo.', 90.00, 'img/productos/velo1.jpg');

-- 8. Índices para rendimiento
CREATE INDEX idx_novias_email ON novias(email);
CREATE INDEX idx_appointments_fecha ON appointments(fecha_cita);
CREATE INDEX idx_products_category ON products(category);
CREATE INDEX idx_appointments_estado ON appointments(estado);

-- Fin del script