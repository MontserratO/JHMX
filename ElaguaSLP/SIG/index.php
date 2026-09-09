<?php

/**
 * Portada del Sistema de Información Geográfica.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$secciones = [
    [
        'ruta'  => 'ElaguaSLP/SIG/administracionAgu',
        'icono' => 'fa-solid fa-hand-holding-droplet',
        'titulo' => 'Administración de Agua',
        'desc'  => 'Zonas Económicas de San Luis Potosí y Regiones Administrativas de Agua',
    ],
    [
        'ruta'  => 'ElaguaSLP/SIG/presas',
        'icono' => 'fa-solid fa-water',
        'titulo' => 'Presas',
        'desc'  => 'Ubicación e información de las principales presas de San Luis Potosí',
    ],
    [
        'ruta'  => 'ElaguaSLP/SIG/acuiferosSLP',
        'icono' => 'fa-solid fa-mountain-city',
        'titulo' => 'Crecimiento de la ciudad',
        'desc'  => 'Acuiferos y crecimiento urbano de la ciudad de San Luis Potosí',
    ],
    [
        'ruta'  => 'ElaguaSLP/SIG/mapas',
        'icono' => 'bi bi-map-fill',
        'titulo' => 'Mapas',
        'desc'  => 'Cartografía temática del estado: cuencas, corrientes, '
                 . 'manantiales, bordos, corrientes, acuíferos, zonas urbanas y regiones hidrológicas.',
    ],
];

View::render('sig', [
    'secciones' => $secciones,
], [
    'titulo'      => 'Sistema de Información Geográfica — Agua en San Luis Potosí',
    'descripcion' => 'Sistema de Información Geográfica sobre los recursos hídricos de San Luis Potosí.',
    'body_id'     => 'SIG',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
]);
