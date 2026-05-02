<?php
/**
 * Script de actualización directa de base de datos para Render.
 * Se salta el enrutador para evitar problemas de matching.
 */

// Cargamos el bootstrap para tener acceso a las variables de entorno y configuración
require_once __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json');

try {
    // Obtenemos la URL de la base de datos de Render
    $databaseUrl = $_ENV['DATABASE_URL'] ?? null;
    
    if (!$databaseUrl) {
        throw new Exception("Error: Variable DATABASE_URL no encontrada.");
    }

    // Parseamos la URL de PostgreSQL
    $url = parse_url($databaseUrl);
    $host = $url['host'];
    $port = $url['port'] ?? '5432';
    $user = $url['user'];
    $pass = $url['pass'];
    $name = ltrim($url['path'], '/');

    // Conexión PDO directa
    $dsn = "pgsql:host=$host;port=$port;dbname=$name";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Ruta al archivo SQL
    $sqlPath = __DIR__ . '/../database_pg.sql';
    if (!file_exists($sqlPath)) {
        throw new Exception("Error: Archivo database_pg.sql no encontrado en la raíz.");
    }

    $sql = file_get_contents($sqlPath);

    // Ejecución
    $pdo->exec($sql);

    echo json_encode([
        'success' => true,
        'message' => 'Base de datos actualizada con éxito desde el archivo SQL.',
        'details' => 'Se han ejecutado los comandos de database_pg.sql correctamente.'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
