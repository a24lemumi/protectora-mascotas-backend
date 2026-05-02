<?php

require_once __DIR__ . '/../app/bootstrap.php';

header('Content-Type: text/html; charset=utf-8');

echo "<h1>Actualización de Base de Datos</h1>";

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
    
    // Verificar si la tabla mascotas existe y tiene datos
    $count = $db->query("SELECT COUNT(*) FROM mascotas")->fetchColumn();
    echo "<p>Registros actuales en mascotas: $count</p>";
    
    if ($count == 0) {
        echo "<p>Insertando mascotas de ejemplo...</p>";
        
        $mascotas = [
            ['Rex', 'perro', 'Pastor Alemán', '2020-03-15', '/imagenes/rex.jpeg'],
            ['Luna', 'gato', 'Europeo', '2019-08-22', '/imagenes/luna.jpeg'],
            ['Toby', 'perro', 'Golden Retriever', '2021-01-10', '/imagenes/toby.jpeg'],
            ['Miau', 'gato', 'Siames', '2020-06-05', '/imagenes/miau.jpeg'],
            ['Rocky', 'perro', 'Bulldog', '2018-11-03', '/imagenes/rocky.jpeg'],
            ['Nina', 'gato', 'Abisinio', '2022-05-12', '/imagenes/nina.jpeg'],
            ['Thor', 'perro', 'Mastín', '2017-04-18', '/imagenes/thor.jpeg'],
            ['Lola', 'gato', 'Persa', '2020-09-30', '/imagenes/lola.jpeg'],
        ];
        
        $stmt = $db->prepare("INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) VALUES (?, ?, ?, ?, ?, NULL)");
        
        foreach ($mascotas as $m) {
            $stmt->execute($m);
            echo "<p>  ✓ {$m[0]} ({$m[1]})</p>";
        }
        
        echo "<p><strong>✓ Base de datos actualizada correctamente</strong></p>";
    } else {
        echo "<p>La base de datos ya tiene datos. No se insertaron nuevos registros.</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>ERROR: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr><p><a href='/'>Volver</a></p>";
