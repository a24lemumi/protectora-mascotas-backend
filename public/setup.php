<?php

require_once __DIR__ . '/../app/bootstrap.php';

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Reset Completo de Base de Datos</h1>";

try {
    // Usar la misma conexión que DBAbstractModel
    $databaseUrl = $_ENV['DATABASE_URL'] ?? null;
    
    if ($databaseUrl) {
        $url = parse_url($databaseUrl);
        $host = $url['host'] ?? 'localhost';
        $port = $url['port'] ?? '5432';
        $user = $url['user'] ?? 'postgres';
        $pass = $url['pass'] ?? '';
        $name = ltrim($url['path'] ?? '', '/');
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$name";
        $db = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } else {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $port = $_ENV['DB_PORT'] ?? '5432';
        $user = $_ENV['DB_USER'] ?? 'postgres';
        $pass = $_ENV['DB_PASS'] ?? '';
        $name = $_ENV['DB_NAME'] ?? 'protectora';
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$name";
        $db = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    
    echo "<p>✓ Conexión exitosa</p>";
    
    // Borrar tablas existentes (siempre)
    echo "<p>Borrando tablas existentes...</p>";
    $db->exec("DROP TABLE IF EXISTS mascotas CASCADE");
    $db->exec("DROP TABLE IF EXISTS usuarios CASCADE");
    echo "<p>✓ Tablas borradas</p>";
    
    // Crear tabla usuarios
    echo "<p>Creando tabla usuarios...</p>";
    $db->exec("CREATE TABLE usuarios (
        id SERIAL PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        telefono VARCHAR(20),
        password VARCHAR(255) NOT NULL,
        nombre VARCHAR(50),
        apellido VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p>✓ Tabla usuarios creada</p>";
    
    // Crear tabla mascotas
    echo "<p>Creando tabla mascotas...</p>";
    $db->exec("CREATE TABLE mascotas (
        id SERIAL PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        especie VARCHAR(50) NOT NULL,
        raza VARCHAR(100),
        fecha_nac DATE,
        imagen VARCHAR(255),
        usuario_id INT NULL,
        CONSTRAINT fk_mascotas_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL ON UPDATE CASCADE
    )");
    echo "<p>✓ Tabla mascotas creada</p>";
    
    // Insertar usuarios
    echo "<p>Insertando usuarios de ejemplo...</p>";
    $password = password_hash('password123', PASSWORD_DEFAULT);
    
    $usuarios = [
        ['ana_garcia', 'ana.garcia@email.com', '612345678', $password, 'Ana', 'García'],
        ['luis_martinez', 'luis.martinez@email.com', '623456789', $password, 'Luis', 'Martínez'],
        ['maria_lopez', 'maria.lopez@email.com', '634567890', $password, 'María', 'López'],
        ['paco_ortega', 'paco.ortega@email.com', '645678901', $password, 'Paco', 'Ortega'],
        ['carla_diaz', 'carla.diaz@email.com', '656789012', $password, 'Carla', 'Díaz'],
    ];
    
    $stmt = $db->prepare("INSERT INTO usuarios (username, email, telefono, password, nombre, apellido) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($usuarios as $u) {
        $stmt->execute($u);
        echo "<p>  ✓ {$u[4]} {$u[5]} ({$u[0]})</p>";
    }
    
    // Insertar mascotas
    echo "<p>Insertando mascotas de ejemplo...</p>";
    
    $mascotas = [
        ['Rex', 'perro', 'Pastor Alemán', '2020-03-15', '/imagenes/rex.jpeg', null],
        ['Luna', 'gato', 'Europeo', '2019-08-22', '/imagenes/luna.jpeg', null],
        ['Toby', 'perro', 'Golden Retriever', '2021-01-10', '/imagenes/toby.jpeg', null],
        ['Miau', 'gato', 'Siames', '2020-06-05', '/imagenes/miau.jpeg', null],
        ['Rocky', 'perro', 'Bulldog', '2018-11-03', '/imagenes/rocky.jpeg', null],
        ['Nina', 'gato', 'Abisinio', '2022-05-12', '/imagenes/nina.jpeg', null],
        ['Thor', 'perro', 'Mastín', '2017-04-18', '/imagenes/thor.jpeg', null],
        ['Lola', 'gato', 'Persa', '2020-09-30', '/imagenes/lola.jpeg', null],
    ];
    
    $stmt = $db->prepare("INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($mascotas as $m) {
        $stmt->execute($m);
        echo "<p>  ✓ {$m[0]} ({$m[1]})</p>";
    }
    
    echo "<p><strong>✓ Base de datos reseteada y poblada correctamente</strong></p>";
    echo "<p>Usuarios creados con contraseña: <code>password123</code></p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>ERROR: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr><p><a href='/'>Volver</a></p>";
