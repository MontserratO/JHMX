<?php

/**
 * Datos para la página del equipo de investigación.
 */

require_once __DIR__ . '/app/bootstrap.php';

$equipoRepo = new EquipoRepository();
$grupos     = $equipoRepo->porCategorias();

View::render('equipo', [
    'grupos' => $grupos,
], [
    'titulo'      => 'Equipo de investigación — Justicia Hídrica México',
    'descripcion' => 'Investigadores y colaboradores del proyecto Justicia Hídrica en México.',
    'body_id'     => 'Equipo',
    'navbars'     => ['navbar-colsan', 'navbar-gen'],
    'js'          => [base_url('assets/js/equipo.js')],
]);
