<?php
    /**
     * Descripcion: Archivo de entrada principal para la aplicación de Contactos.
     * Se encarga de cargar el entorno, configurar rutas y despachar las solicitudes.
     * 
     * @author Miguel Ángel Leiva
     * @date 24-02-2026
    */

namespace App\Core;

class Router
{
    private $routes = [];

    // Permite configurar un prefijo común para todas las rutas, útil para despliegues en subdirectorios.
    private $basePath = '';

    // Permite configurar un prefijo común para todas las rutas, útil para despliegues en subdirectorios.
    public function setBasePath($basePath) {
        $this->basePath = rtrim($basePath, '/');
    }

    // Registra una ruta para el método GET.
    public function get(string $path, array $handler, array $middlewares = []): void {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    // Registra una ruta para el método POST.
    public function post(string $path, array $handler, array $middlewares = []): void {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    // Método privado que centraliza la lógica de registro de rutas, creando un patrón regex para la coincidencia.
    private function addRoute(string $method, string $path, array $handler, array $middlewares = []): void
    {
        $normalizedPath = $this->basePath . '/' . ltrim($path, '/');
        $pattern = $this->convertPathToRegex($normalizedPath);

        $this->routes[] = [
            'method'      => strtoupper($method),
            'pattern'     => $pattern,
            'handler'     => $handler,
            'middlewares' => $middlewares,
        ];
    }

    // Convierte una ruta con parámetros (e.g., /contactos/{id}) a una expresión regular para su coincidencia.
    private function convertPathToRegex($path)
    {
        $pattern = preg_quote($path, '#');
        $pattern = preg_replace('/\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }

    // Intenta encontrar una ruta que coincida con el método HTTP y la URI proporcionados, devolviendo los detalles de la ruta si se encuentra una coincidencia.
    public function match(string $method, string $uri): ?array
    {
        $method = strtoupper($method);
        $path   = $this->cleanUri($uri); 

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

        return null; // No se encontró una ruta coincidente
      
    }

    // Limpia la URI de la solicitud, eliminando el query string y el prefijo base si está configurado, para facilitar la coincidencia con las rutas registradas.
    private function cleanUri($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = '/' . trim($path, '/');
        

        if ($this->basePath && strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
            $path = '/' . trim($path, '/');
        }
        
        return $path === '' ? '/' : $path;
    }
}