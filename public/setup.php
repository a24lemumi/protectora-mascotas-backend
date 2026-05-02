<?php
require_once __DIR__ . '/../app/bootstrap.php';
header('Content-Type: text/html; charset=utf-8');
echo "<h1>RESET COMPLETO</h1>";
try {
    $databaseUrl = $_ENV['DATABASE_URL'] ?? null;
    if ($databaseUrl) {
        $url = parse_url($databaseUrl);
        $db = new PDO("pgsql:host={$url['host']};port={$url['port']};dbname=" . ltrim($url['path'], '/'), $url['user'], $url['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } else {
        $db = new PDO("pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    echo "<p>Conectado</p>";
    $db->exec("DROP TABLE IF EXISTS mascotas CASCADE");
    $db->exec("DROP TABLE IF EXISTS usuarios CASCADE");
    echo "<p>Tablas borradas</p>";
    $db->exec("CREATE TABLE usuarios (id SERIAL PRIMARY KEY, username VARCHAR(50) NOT NULL UNIQUE, email VARCHAR(100) NOT NULL UNIQUE, telefono VARCHAR(20), password VARCHAR(255) NOT NULL, nombre VARCHAR(50), apellido VARCHAR(100), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    $db->exec("CREATE TABLE mascotas (id SERIAL PRIMARY KEY, nombre VARCHAR(100) NOT NULL, especie VARCHAR(50) NOT NULL, raza VARCHAR(100), fecha_nac DATE, imagen VARCHAR(255), usuario_id INT NULL, CONSTRAINT fk_mascotas_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE)");
    echo "<p>Tablas creadas</p>";
    $pw = password_hash('password123', PASSWORD_DEFAULT);
    $db->prepare("INSERT INTO usuarios (username, email, telefono, password, nombre, apellido) VALUES (?,?,?,?,?,?)")->execute(['ana','ana@email.com','111','$pw','Ana','García']);
    $db->prepare("INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES (?,?,?,?,?,?)")->execute(['Rex','perro','Pastor Alemán','2020-03-15','/imagenes/rex.jpeg',null]);
    $db->prepare("INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES (?,?,?,?,?,?)")->execute(['Luna','gato','Europeo','2019-08-22','/imagenes/luna.jpeg',null]);
    $db->prepare("INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES (?,?,?,?,?,?)")->execute(['Toby','perro','Golden Retriever','2021-01-10','/imagenes/toby.jpeg',null]);
    echo "<p><strong>¡LISTO! Mascotas sin dueño</strong></p>";
} catch (Exception $e) {
    echo "<p style='color:red'>ERROR: " . htmlspecialchars($e->getMessage()) . "</p>";
}
