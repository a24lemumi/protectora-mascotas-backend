<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$databaseUrl = $_ENV['DATABASE_URL'] ?? null;
if ($databaseUrl) {
    $url = parse_url($databaseUrl);
    $host = $url['host'] ?? 'localhost';
    $port = $url['port'] ?? '5432';
    $user = $url['user'] ?? 'postgres';
    $pass = $url['pass'] ?? '';
    $dbname = ltrim($url['path'] ?? '', '/');
} else {
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $user = $_ENV['DB_USER'] ?? 'postgres';
    $pass = $_ENV['DB_PASS'] ?? '';
    $dbname = $_ENV['DB_NAME'] ?? '';
    $port = $_ENV['DB_PORT'] ?? '5432';
}

$dsn = sprintf('pgsql:host=%s;dbname=%s;port=%s', $host, $dbname, $port);

try {
    echo "Conectando a la base de datos: $dbname en $host...\n";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    $sqlFile = __DIR__ . '/database_pg.sql';
    if (!file_exists($sqlFile)) {
        die("Error: No se encuentra el archivo $sqlFile\n");
    }
    
    $sql = file_get_contents($sqlFile);
    
    echo "Ejecutando script de base de datos...\n";
    // Dividir por punto y coma para ejecutar sentencias individuales si es necesario, 
    // pero con PostgreSQL podemos ejecutar el bloque completo si no hay comandos de psql (\c, etc)
    // El archivo del usuario tiene DROP TABLE y CREATE TABLE, que son estándar.
    
    $pdo->exec($sql);
    echo "¡Base de datos actualizada con éxito!\n";
} catch (PDOException $e) {
    die("Error al actualizar la base de datos: " . $e->getMessage() . "\n");
}
