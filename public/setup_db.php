<?php
/**
 * Database Setup Script for Render.com Deployment
 * 
 * WARNING: Delete this file immediately after use!
 * This script drops and recreates the entire database.
 */

require_once __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json');

try {
    // Usamos un modelo concreto (MascotasModel) para obtener la conexión
    $model = new \App\Models\MascotasModel();
    $db = $model->getConnection();
    
    // Read the PostgreSQL SQL file
    $sqlFile = __DIR__ . '/../database_pg.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception('database_pg.sql file not found');
    }
    
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception('Failed to read database_pg.sql');
    }
    
    // Execute the SQL
    $result = $db->exec($sql);
    
    // Get list of created tables
    $tables = $db->query("
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = 'public' 
        ORDER BY table_name
    ")->fetchAll();
    
    echo json_encode([
        'success' => true,
        'timestamp' => date('c'),
        'message' => 'Database initialized successfully',
        'tables_created' => array_column($tables, 'table_name'),
        'rows_affected' => $result
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'timestamp' => date('c'),
        'error' => [
            'code' => 'DB_SETUP_ERROR',
            'message' => $e->getMessage()
        ]
    ]);
}

exit;
