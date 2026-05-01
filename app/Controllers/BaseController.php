<?php 
    /**
     * Descripcion: Controlador base que proporciona funcionalidades comunes a todos los controladores
     * de la aplicación.
     *
     * @author Miguel Ángel Leiva
     * @date 24-02-2026
    */

    namespace App\Controllers;

    class BaseController {

        // Constructor del BaseController
        public function __construct() {
        
        }
        
        // Renderiza una vista HTML utilizando un sistema de plantillas
        public function renderHTML($fileName, $data = []) {

            if (!file_exists($fileName)) {
                $this->mostrarError("La vista solicitada no existe: " . basename($fileName), 500);
                return;
            }

            $helpersPath = VIEWS_DIR . '/helpers/main_helper.php';
            if (file_exists($helpersPath)) {
                require_once $helpersPath;
            }

            // Extraer variables para que estén disponibles en la vista
            extract($data);

            // Inicia el almacenamiento en búfer de salida para capturar el contenido generado por la vista.
            ob_start();
            // Incluye el archivo de la vista, que puede utilizar las variables definidas en $data.
            include $fileName;
            // Obtiene el contenido generado por la vista y limpia el búfer de salida.
            $content = ob_get_clean();

            // Extraer variables del array $data para que estén disponibles en el layout
            extract($data);
            $titulo_pagina = $data['titulo_pagina'] ?? $data['titulo'] ?? 'Agenda de Contactos';

            $layoutPath = VIEWS_DIR . '/layouts/base_view.php';
            if (file_exists($layoutPath)) {
                include $layoutPath;
            } else {
                echo $content; // Fallback si no hay layout
            }
        }
        
        // Redirige al usuario a una URL específica
        protected function redirect($url) {
            $fullUrl = (strpos($url, 'http') === 0) ? $url : BASE_URL . $url;
            header('Location: ' . $fullUrl);
            exit;
        }

        // Muestra una página de error personalizada
        public function mostrarError($mensaje, $codigo = 404) {
            http_response_code($codigo);
            $data = [
                'titulo'  => 'Ups! Algo ha ido mal',
                'mensaje' => $mensaje,
                'codigo'  => $codigo
            ];

            include VIEWS_DIR . '/errors/general_error.php';
            exit;
        }
    }