<?php
    namespace App\Middleware;

    class JwtMiddleware {
        public function handle() {
            // Intentar obtener el token de diferentes fuentes comunes
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
            
            if (empty($authHeader) && function_exists('getallheaders')) {
                $headers = getallheaders();
                $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
            }

            if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'TOKEN_MISSING',
                        'message' => 'Token de autenticación requerido'
                    ]
                ]);
                exit;
            }

            $token = $matches[1];
            $secret = $_ENV['JWT_SECRET'] ?? '';

            if (empty($secret)) {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'SERVER_ERROR',
                        'message' => 'Configuración JWT no encontrada'
                    ]
                ]);
                exit;
            }

            try {
                $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($secret, 'HS256'));
                $_SERVER['JWT_USER'] = (array) $decoded;
                return true;
            } catch (\Firebase\JWT\ExpiredException $e) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'TOKEN_EXPIRED',
                        'message' => 'Token expirado'
                    ]
                ]);
                exit;
            } catch (\Exception $e) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'TOKEN_INVALID',
                        'message' => 'Token inválido'
                    ]
                ]);
                exit;
            }
        }
    }
