<?php

/**
 * Configuración central del sitio.
 */

// Evita que el archivo se ejecute si se accede directamente por URL.
defined('JH_APP') || exit('Acceso no permitido.');

return [

    // --- Base de datos ---
    'db' => [
        'host'    => 'localhost',
        'name'    => 'elaguaenslp',
        'user'    => 'root',
        'pass'    => '',
        'charset' => 'utf8mb4',
    ],

    // --- Entorno ---
    // 'dev'  → muestra errores en pantalla (solo en tu Laragon local).
    // 'prod' → oculta errores al visitante y los manda al log (en el servidor).
    'env' => 'prod',

    // Ruta base del sitio dentro del dominio.
    'base_path' => '/justiciahidricamx/',
];