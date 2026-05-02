<?php

/**
 * Descripcion: Router class for handling HTTP route matching.
 * 
 * @author Miguel Ángel Leiva
 * @date 24-02-2026
 */

namespace App\Core;

class Router
{
    private $routes = [];

    // Register a GET route.
    public function get(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    // Register a POST route.
    public function post(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    // Private method to add routes with regex pattern.
    private function addRoute(string $method, string $path, array $handler, array $middlewares = []): void
    {
        $pattern = $this->convertPathToRegex($path);

        $this->routes[] = [
            'method'      => strtoupper($method),
            'pattern'     => $pattern,
            'handler'     => $handler,
            'middlewares' => $middlewares,
        ];
    }

    // Convert path with parameters to regex.
    private function convertPathToRegex($path)
    {
        $pattern = preg_quote($path, '#');
        $pattern = preg_replace('/\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }

    // Match route by HTTP method and URI.
    public function match(string $method, string $uri): ?array
    {
        $method = strtoupper($method);
        $path   = $this->cleanUri($uri);

        // DEBUG TEMPORAL
        die(json_encode(["metodo" => $method, "ruta_limpia" => $path, "uri_original" => $uri]));

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                return [
                    'handler' => $route['handler'],
                    'params'  => $params,
                    'middlewares' => $route['middlewares'],
                ];
            }
        }

        if ($path === '/debug-routes') {
            header('Content-Type: application/json');
            echo json_encode($this->routes);
            exit;
        }

        return null;
    }

    // Clean URI by removing query string.
    private function cleanUri($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        return '/' . trim($path, '/');
    }
}
