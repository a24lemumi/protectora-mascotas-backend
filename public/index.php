<?php

/**
 * Descripcion: Archivo de entrada principal para la aplicación de Contactos.
 * Se encarga de cargar el entorno, configurar rutas y despachar las solicitudes.
 * 
 * @author Miguel Ángel Leiva
 * @date 24-02-2026
 */

require_once __DIR__ . '/../app//bootstrap.php';

use App\Core\Router;
use App\Core\Dispatcher;
use App\Controllers\MascotasController;

$router = new Router();

// --- Definición de Rutas ---

$router->get('/api/mascotas', [MascotasController::class, 'index']);
$router->get('/api/mascotas/{id}', [MascotasController::class, 'show']);
$router->get('/health', [MascotasController::class, 'health']);

// --- Proceso de Despacho ---
$route = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

$dispatcher = new Dispatcher();
$dispatcher->dispatch($route);
