<?php

/**
 * Paginas estaticas de Crecimiento urbano y acuífero.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$periodos = [
    '1959' => '#1a0b2e',
    '1970' => '#331a5c',
    '1980' => '#5b1e6e',
    '1990' => '#8c1d6e',
    '2000' => '#b31b5e',
    '2005' => '#d81b53',
    '2010' => '#e05a3c',
    '2015' => '#e8801f',
    '2020' => '#dda23a',
    '2024' => '#c9c72e',
];

View::render('sig-acuiferos', [
    'periodos' => $periodos,
], [
    'titulo'      => 'Crecimiento de la ciudad — SIG, Agua en San Luis Potosí',
    'descripcion' => 'Expansión de la mancha urbana de San Luis Potosí sobre el acuífero que la abastece, de 1959 a 2024.',
    'body_id'     => 'SIGAcuiferos',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/visor-mapa.js')],
]);
