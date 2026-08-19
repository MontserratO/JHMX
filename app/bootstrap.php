<?php
define('JH_APP', true);

// --- Carga de configuración ---
$config = require __DIR__ . '/config.php';
$GLOBALS['config'] = $config;

// --- Manejo de errores según entorno ---
if (($config['env'] ?? 'prod') === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

// --- Sesión segura ---
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => (($_SERVER['HTTPS'] ?? '') === 'on'
                        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'),
    ]);
    ini_set('session.use_strict_mode', '1');
    session_start();
}

// --- Autoloader de clases ---
spl_autoload_register(function (string $class): void {
    foreach (['/', '/repositories/'] as $dir) {
        $path = __DIR__ . $dir . $class . '.php';
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

// --- Helpers (funciones sueltas, no clases: se cargan a mano) ---
require_once __DIR__ . '/helpers.php';