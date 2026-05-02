DROP DATABASE IF EXISTS protectora;
CREATE DATABASE protectora;
USE protectora;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(50),
    apellido VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raza VARCHAR(100),
    fecha_nac DATE,
    imagen VARCHAR(255),
    usuario_id INT NULL,
    CONSTRAINT fk_mascotas_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO usuarios (username, email, telefono, password, nombre, apellido) VALUES
    ('ana_garcia', 'ana.garcia@email.com', '612345678', '$2y$10$ejemplohash123', 'Ana', 'García'),
    ('luis_martinez', 'luis.martinez@email.com', '623456789', '$2y$10$ejemplohash456', 'Luis', 'Martínez'),
    ('maria_lopez', 'maria.lopez@email.com', '634567890', '$2y$10$ejemplohash789', 'María', 'López'),
    ('paco_ortega', 'paco.ortega@email.com', '645678901', '$2y$10$ejemplohash234', 'Paco', 'Ortega'),
    ('carla_diaz', 'carla.diaz@email.com', '656789012', '$2y$10$ejemplohash567', 'Carla', 'Díaz');

INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES
    ('Rex', 'perro', 'Pastor Alemán', '2020-03-15', '/imagenes/rex.jpg', 1),
    ('Luna', 'gato', 'Europeo', '2019-08-22', '/imagenes/luna.jpg', 2),
    ('Toby', 'perro', 'Golden Retriever', '2021-01-10', '/imagenes/toby.jpg', 3),
    ('Miau', 'gato', 'Siamés', '2020-06-05', '/imagenes/miau.jpg', 1),
    ('Rocky', 'perro', 'Bulldog', '2018-11-03', '/imagenes/rocky.jpg', 4),
    ('Nina', 'gato', 'Abisinio', '2022-05-12', '/imagenes/nina.jpg', 5),
    ('Thor', 'perro', 'Mastín', '2017-04-18', '/imagenes/thor.jpg', NULL),
    ('Lola', 'gato', 'Persa', '2020-09-30', '/imagenes/lola.jpg', NULL);