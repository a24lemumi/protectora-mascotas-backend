<?php

namespace App\Controllers;

use App\Models\MascotasModel;
use App\Forms\MascotaForm;

class MascotasController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new MascotasModel();
    }

    public function index()
    {
        $mascotas = $this->model->readAll(1, null, [], true);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'timestamp' => date('c'),
            'data' => $mascotas
        ]);
        exit;
    }

    public function show($id)
    {
        $mascota = $this->model->read($id);
        if (!$mascota) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Mascota no encontrada'
                ]
            ]);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'timestamp' => date('c'),
            'data' => $mascota
        ]);
        exit;
    }

    public function create()
    {
        $jwtUser = $_SERVER['JWT_USER'] ?? null;
        if (!$jwtUser) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'UNAUTHORIZED',
                    'message' => 'Autenticación requerida'
                ]
            ]);
            exit;
        }

        $form = new MascotaForm();
        if (!$form->submit()) {
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
        $data['usuario_id'] = $jwtUser['user_id'];

        $mascotaId = $this->model->create($data);
        if ($mascotaId) {
            header('Content-Type: application/json');
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'timestamp' => date('c'),
                'data' => ['id' => $mascotaId],
                'message' => 'Mascota creada exitosamente'
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
                'message' => 'Error al crear mascota'
            ]
        ]);
        exit;
    }

    public function handleUpdateDelete($id)
    {
        $jwtUser = $_SERVER['JWT_USER'] ?? null;
        if (!$jwtUser) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'UNAUTHORIZED',
                    'message' => 'Autenticación requerida'
                ]
            ]);
            exit;
        }

        $mascota = $this->model->read($id);
        if (!$mascota) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Mascota no encontrada'
                ]
            ]);
            exit;
        }

        $postData = $_POST;
        $jsonData = json_decode(file_get_contents('php://input'), true);
        $method = strtoupper($postData['_method'] ?? $jsonData['_method'] ?? '');

        if ($method === 'PUT') {
            return $this->performUpdate($id, $jwtUser);
        } elseif ($method === 'DELETE') {
            return $this->performDelete($id, $jwtUser);
        } else {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'INVALID_METHOD',
                    'message' => 'Para actualizar usa _method=PUT, para eliminar usa _method=DELETE'
                ]
            ]);
            exit;
        }
    }

    private function performUpdate($id, $jwtUser)
    {
        $form = new MascotaForm();
        if (!$form->submit()) {
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

        if ($this->model->update($id, $data, $jwtUser['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'timestamp' => date('c'),
                'data' => ['id' => $id],
                'message' => 'Mascota actualizada exitosamente'
            ]);
            exit;
        }

        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'timestamp' => date('c'),
            'error' => [
                'code' => 'UPDATE_ERROR',
                'message' => 'Error al actualizar mascota'
            ]
        ]);
        exit;
    }

    private function performDelete($id, $jwtUser)
    {
        if ($this->model->deleteWithOwner($id, $jwtUser['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'timestamp' => date('c'),
                'message' => 'Mascota eliminada exitosamente'
            ]);
            exit;
        }

        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'timestamp' => date('c'),
            'error' => [
                'code' => 'FORBIDDEN',
                'message' => 'No tienes permiso para eliminar esta mascota'
            ]
        ]);
        exit;
    }

    public function adoptar($id)
    {
        $jwtUser = $_SERVER['JWT_USER'] ?? null;
        if (!$jwtUser) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'UNAUTHORIZED',
                    'message' => 'Autenticación requerida'
                ]
            ]);
            exit;
        }

        $mascota = $this->model->read($id);
        if (!$mascota) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'Mascota no encontrada'
                ]
            ]);
            exit;
        }

        if ($mascota['usuario_id'] !== null) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'timestamp' => date('c'),
                'error' => [
                    'code' => 'ALREADY_ADOPTED',
                    'message' => 'Mascota ya adoptada'
                ]
            ]);
            exit;
        }

        if (MascotasModel::adoptPet($id, $jwtUser['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'timestamp' => date('c'),
                'data' => ['id' => $id],
                'message' => 'Mascota adoptada exitosamente'
            ]);
            exit;
        }

        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'timestamp' => date('c'),
            'error' => [
                'code' => 'ADOPT_ERROR',
                'message' => 'Error al adoptar mascota'
            ]
        ]);
        exit;
    }
}
