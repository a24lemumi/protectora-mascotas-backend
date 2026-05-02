<?php
    namespace App\Middleware;

    class RequestSanitizer {
        public static function validateRequired($data, $requiredFields) {
            $missing = [];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    $missing[] = $field;
                }
            }

            if (!empty($missing)) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'VALIDATION_ERROR',
                        'message' => 'Campos requeridos faltantes: ' . implode(', ', $missing)
                    ]
                ]);
                exit;
            }

            return true;
        }
    }
