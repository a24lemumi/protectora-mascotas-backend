<?php
    namespace App\Middleware;

    class CorsMiddleware {
        public function handle() {
            $allowedOrigins = $_ENV['CORS_ALLOWED_ORIGINS'] ?? '*';

            if ($allowedOrigins === '*') {
                header('Access-Control-Allow-Origin: *');
            } else {
                $origins = explode(',', $allowedOrigins);
                $requestOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';

                if (in_array($requestOrigin, $origins)) {
                    header("Access-Control-Allow-Origin: $requestOrigin");
                }
            }

            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header('Access-Control-Allow-Credentials: true');

            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                http_response_code(200);
                exit;
            }

            return true;
        }
    }
