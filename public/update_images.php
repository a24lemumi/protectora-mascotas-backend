<?php
/**
 * Script de utilidad para actualizar las extensiones de las imágenes
 */
require_once __DIR__ . '/../app/bootstrap.php';

use App\Models\MascotasModel;

header('Content-Type: application/json');

try {
    $model = new MascotasModel();
    $db = $model->getConnection();
    
    // SQL para reemplazar .jpg por .jpeg en la columna imagen
    $sql = "UPDATE mascotas SET imagen = REPLACE(imagen, '.jpg', '.jpeg')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $rows = $stmt->rowCount();
    
    echo json_encode([
        'success' => true,
        'message' => "Base de datos actualizada con éxito",
        'rows_affected' => $rows,
        'new_extension' => '.jpeg'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
