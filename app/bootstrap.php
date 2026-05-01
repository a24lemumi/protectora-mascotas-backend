<?php

/**
 * Descripción: Este archivo es el punto de entrada de la aplicación. 
 * Se encarga de configurar el entorno, cargar dependencias y preparar todo lo necesario para que la aplicación funcione correctamente.
 * 
 * @author Miguel Ángel Leiva
 * @date 24-02-2026
 */

require_once __DIR__ . '/config/config.php';
require_once VENDOR_DIR . '/autoload.php';

ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Iniciar sesión para manejar autenticación
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carga de funciones auxiliares
if (file_exists(APP_DIR . '/helpers/helpers.php')) {
    require_once APP_DIR . '/helpers/helpers.php';
}

// Carga de variables de entorno
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(APP_ROOT);
    $dotenv->load();
    $dotenv->required(['DBHOST', 'DBNAME', 'DBUSER', 'DBPASS'])->notEmpty();
} catch (Exception $e) {
    die('Fallo crítico en configuración: ' . $e->getMessage());
}

// Configuración de entorno y manejo de errores
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
if (APP_ENV === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', 0);
}

// Configuración adicional de seguridad y rendimiento
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '/logs/php_errors.log');
date_default_timezone_set($_ENV['TIMEZONE'] ?? 'Europe/Madrid');

// 7. MANTENIMIENTO DE DIRECTORIOS
$requiredDirs = [APP_ROOT . '/logs', APP_ROOT . '/cache', PUBLIC_DIR . '/uploads/contactos'];
foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// URL BASE PARA VISTAS
// Definición de URL BASE
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$scriptDir = str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']));

// Eliminamos barras finales sobrantes para evitar el error de doble barra //
$baseUrl = rtrim($protocol . $host . $scriptDir, '/\\');
define('BASE_URL', $baseUrl);
