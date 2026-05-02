<?php
    namespace App\Controllers;

    use App\Models\UsuariosModel;
    use App\Forms\UsuarioForm;

    class UsuariosController extends BaseController {
        private $model;

        public function __construct() {
            $this->model = new UsuariosModel();
        }

        public function register() {
            $form = new UsuarioForm();
            if (!$form->submit('register')) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'VALIDATION_ERROR',
                        'message' => implode(', ', $form->getErrors())
                    ]
                ]);
                exit;
            }

            $data = $form->getData();

            if ($this->model->findByEmailForCheck($data['email'])) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'DUPLICATE_EMAIL',
                        'message' => 'El email ya está registrado'
                    ]
                ]);
                exit;
            }

            if ($this->model->findByUsername($data['username'])) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'DUPLICATE_USERNAME',
                        'message' => 'El nombre de usuario ya está en uso'
                    ]
                ]);
                exit;
            }

            $userId = $this->model->create($data);
            if ($userId) {
                header('Content-Type: application/json');
                http_response_code(201);
                echo json_encode([
                    'success' => true,
                    'timestamp' => date('c'),
                    'data' => ['id' => $userId],
                    'message' => 'Usuario registrado exitosamente'
                ]);
                exit;
            }

            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'CREATE_ERROR',
                    'message' => 'Error al registrar usuario'
                ]
            ]);
            exit;
        }

        public function login() {
            $form = new UsuarioForm();
            if (!$form->submit('login')) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'VALIDATION_ERROR',
                        'message' => implode(', ', $form->getErrors())
                    ]
                ]);
                exit;
            }

            $data = $form->getData();

            $user = $this->model->findByEmail($data['email']);
            if (!$user || !password_verify($data['password'], $user['password'])) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'timestamp' => date('c'),
                    'error' => [
                        'code' => 'INVALID_CREDENTIALS',
                        'message' => 'Email o contraseña incorrectos'
                    ]
                ]);
                exit;
            }

            $secret = $_ENV['JWT_SECRET'] ?? '';
            $payload = [
                'user_id' => $user['id'],
                'email' => $user['email'],
                'exp' => time() + 3600
            ];

            $token = \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'timestamp' => date('c'),
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email']
                    ]
                ],
                'message' => 'Login exitoso'
            ]);
            exit;
        }
    }
