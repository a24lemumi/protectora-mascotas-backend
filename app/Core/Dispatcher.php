<?php

/**
 * Descripcion: Dispatcher for handling route execution.
 * 
 * @author Miguel Ángel Leiva
 * @date 24-02-2026
 */

namespace App\Core;

class Dispatcher
{
    private $globalMiddlewares = [];

    // Añade un middleware global que se ejecutará en todas las rutas
    public function addGlobalMiddleware($middlewareClass) {
        $this->globalMiddlewares[] = $middlewareClass;
    }

    // Ejecuta la lógica asociada a una ruta encontrada por el Router.
    public function dispatch(?array $route)
    {
        if (!$route) {
            return $this->handleNotFound();
        }

        // Ejecutar middlewares globales primero
        if (!$this->executeMiddlewares($this->globalMiddlewares)) {
            return;
        }

        // Ejecutar middlewares específicos de la ruta
        $middlewares = $route['middlewares'] ?? [];
        if (!$this->executeMiddlewares($middlewares)) {
            // Si algún middleware falla, detener la ejecución
            return;
        }

        [$controllerName, $actionName] = $route['handler'];
        $params = $route['params'] ?? [];

        if (!class_exists($controllerName)) {
            return $this->handleError("El controlador '$controllerName' no existe.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            return $this->handleError("La acción '$actionName' no existe en el controlador.");
        }

        return call_user_func_array([$controller, $actionName], $params);
    }

    // Ejecuta todos los middlewares asociados a una ruta
    private function executeMiddlewares(array $middlewares): bool
    {
        foreach ($middlewares as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                $this->handleError("El middleware '$middlewareClass' no existe.");
                return false;
            }

            $middleware = new $middlewareClass();
            
            // Ejecutar el método handle del middleware
            if (method_exists($middleware, 'handle')) {
                $result = $middleware->handle();
                // Si el middleware retorna false, detener la ejecución
                if ($result === false) {
                    return false;
                }
            }
        }

        return true;
    }

    // Se encarga de mostrar un mensaje de error específico cuando no se encuentra una ruta coincidente.
    private function handleNotFound()
    {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'timestamp' => date('c'),
            'error' => [
                'code' => 'ROUTE_NOT_FOUND',
                'message' => 'Ruta no encontrada'
            ]
        ]);
        exit;
    }

    // Se encarga de mostrar un mensaje de error genérico cuando ocurre un problema con el controlador o la acción.
    private function handleError(string $mensaje)
    {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'timestamp' => date('c'),
            'error' => [
                'code' => 'DISPATCHER_ERROR',
                'message' => $mensaje
            ]
        ]);
        exit;
    }
}
