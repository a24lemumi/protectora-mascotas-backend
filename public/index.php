<?php

/**
 * Descripcion: Archivo de entrada principal para la aplicación.
 * Se encarga de cargar el entorno, configurar rutas y despachar las solicitudes.
 * 
 * @author Miguel Ángel Leiva
 * @date 24-02-2026
 */

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Router;
use App\Core\Dispatcher;
use App\Controllers\MascotasController;
use App\Controllers\UsuariosController;

$router = new Router();

// --- Definición de Rutas Públicas ---
$router->post('/api/auth/login', [UsuariosController::class, 'login']);
$router->post('/api/usuarios', [UsuariosController::class, 'register']);

// --- Definición de Rutas Protegidas (Requieren JWT) ---
// Mascotas
$router->get('/api/mascotas', [MascotasController::class, 'index'], [App\Middleware\JwtMiddleware::class]);
$router->get('/api/mascotas/{id}', [MascotasController::class, 'show'], [App\Middleware\JwtMiddleware::class]);
$router->post('/api/mascotas', [MascotasController::class, 'create'], [App\Middleware\JwtMiddleware::class]);
$router->post('/api/mascotas/{id}', [MascotasController::class, 'update'], [App\Middleware\JwtMiddleware::class]);
$router->post('/api/mascotas/{id}', [MascotasController::class, 'delete'], [App\Middleware\JwtMiddleware::class]);
$router->post('/api/mascotas/{id}/adoptar', [MascotasController::class, 'adoptar'], [App\Middleware\JwtMiddleware::class]);

// --- Proceso de Despacho ---
$route = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

$dispatcher = new Dispatcher();
$dispatcher->dispatch($route);
