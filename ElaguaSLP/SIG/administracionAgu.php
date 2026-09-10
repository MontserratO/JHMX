<?php

/**
 * Pagina estatica de Zonas económicas y regiones
 * administrativas del agua.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$zonas = [
    'altO'    => 'Altiplano oeste',
    'huasN'   => 'Huasteca norte',
    'centro'  => 'Centro',
    'mediaO'  => 'Media oeste',
    'altC'    => 'Altiplano centro',
    'huasC'   => 'Huasteca centro',
    'centroS' => 'Centro sur',
    'mediaE'  => 'Media este',
    'altE'    => 'Altiplano este',
    'huasS'   => 'Huasteca sur',
];

View::render('sig-administracion', [
    'zonas' => $zonas,
], [
    'titulo'      => 'Administración de Agua — SIG, Agua en San Luis Potosí',
    'descripcion' => 'Zonas económicas de San Luis Potosí y regiones administrativas del agua según la CONAGUA.',
    'body_id'     => 'SIGAdmin',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/mapa-slp.js')],
]);
