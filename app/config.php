<?php


// Evita que el archivo se ejecute si se accede directamente por URL.
defined('JH_APP') || exit('Acceso no permitido.');

return [

    // --- Base de datos ---
    // Reemplaza con las credenciales REALES del servidor de Colsan.
    // (Las de root/'' eran solo de tu XAMPP local.)
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


    // ** cambiar en el server /justiciahidricamx/**
    'base_path' => '/JHMX/',
];
