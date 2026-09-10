<?php

/**
 * Visor de mapas con capas de información.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$capas = [

    // --- Hidrografía ---
    'manantiales' => [
        'archivo' => 'Manantiales', 'etiqueta' => 'Manantiales',
        'grupo' => 'Hidrografía', 'tipo' => 'punto',
        'color' => '#497f8a', 'relleno' => '#a2eeff', 'opacidad' => 0.6,
        'activa' => false, 'campo' => null,
    ],
    'bordos' => [
        'archivo' => 'Bordos', 'etiqueta' => 'Bordos de agua',
        'grupo' => 'Hidrografía', 'tipo' => 'poligono',
        'color' => '#5b2f64', 'relleno' => '#5b2f64', 'opacidad' => 1,
        'activa' => false, 'campo' => null,
    ],
    'corrientes' => [
        'archivo' => 'Corrientes', 'etiqueta' => 'Corrientes',
        'grupo' => 'Hidrografía', 'tipo' => 'linea',
        'color' => '#538add', 'relleno' => null, 'opacidad' => 1,
        'activa' => false, 'campo' => 'TIPO',
        'sub' => ['Perenne' => '#538add', 'Intermitente' => '#a9c6e8'],
    ],
    'acuiferos' => [
        'archivo' => 'Acuiferos', 'etiqueta' => 'Acuíferos del centro',
        'grupo' => 'Hidrografía', 'tipo' => 'poligono',
        'color' => '#95b2d2', 'relleno' => '#b9e8f0', 'opacidad' => 0.6,
        'activa' => false, 'campo' => 'NOM_ACUI',
    ],
    'reghidro' => [
        'archivo' => 'RegHidrologicas', 'etiqueta' => 'Regiones hidrológicas',
        'grupo' => 'Hidrografía', 'tipo' => 'poligono',
        'color' => '#5c8a3f', 'relleno' => '#5c8a3f', 'opacidad' => 0.3,
        'activa' => true, 'campo' => 'Nombre',
    ],

    // --- División territorial ---
    'zonas' => [
        'archivo' => 'municipios', 'etiqueta' => 'Zonas administrativas',
        'grupo' => 'División territorial', 'tipo' => 'zonas',
        'color' => null, 'relleno' => null, 'opacidad' => 0.8,
        'activa' => true, 'campo' => 'NOMGEO',
        'sub' => [
            'Altiplano' => '#825a4e', 'Centro' => '#f0cd7c',
            'Media' => '#f6f479', 'Huasteca' => '#5e8846',
        ],
    ],
    'municipios' => [
        'archivo' => 'municipios', 'etiqueta' => 'División municipal',
        'grupo' => 'División territorial', 'tipo' => 'contorno',
        'color' => '#ffffff', 'relleno' => null, 'opacidad' => 0,
        'activa' => true, 'campo' => 'NOMGEO',
        'encuadre' => true,
    ],
    'estatal' => [
        'archivo' => 'LimiteEstatal', 'etiqueta' => 'División estatal',
        'grupo' => 'División territorial', 'tipo' => 'contorno',
        'color' => '#4a7c3f', 'relleno' => null, 'opacidad' => 0,
        'activa' => true, 'campo' => 'NOM_ENT',
    ],

    // --- Asentamientos ---
    'localidades' => [
        'archivo' => 'Localidades', 'etiqueta' => 'Localidades urbanas',
        'grupo' => 'Asentamientos', 'tipo' => 'poligono',
        'color' => '#c9c86e', 'relleno' => '#ffff06', 'opacidad' => 1,
        'activa' => false, 'campo' => 'NOMGEO',
    ],
];

$grupos = [];
foreach ($capas as $clave => $c) {
    $grupos[$c['grupo']][$clave] = $c;
}

View::render('sig-mapas', [
    'capas'  => $capas,
    'grupos' => $grupos,
], [
    'titulo'      => 'Mapas — SIG, Agua en San Luis Potosí',
    'descripcion' => 'Visor de mapas con capas de información hidrológica y territorial de San Luis Potosí.',
    'body_id'     => 'SIGMapas',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        base_url('assets/css/elagua.css'),
    ],
    'js'          => [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
        base_url('assets/js/mapa-capas.js'),
    ],
]);