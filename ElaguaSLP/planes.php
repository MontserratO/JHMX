<?php

/**
 * Pagina estatica de Planes y Programas.
 */

require_once __DIR__ . '/../app/bootstrap.php';

$repo   = new PlanesRepository();
$grupos = $repo->agrupados();

View::render('planes', [
    'grupos' => $grupos,
], [
    'titulo'      => 'Planes y Programas — Agua en San Luis Potosí',
    'descripcion' => 'Planes y programas estatales relacionados con la gestión del agua en San Luis Potosí.',
    'body_id'     => 'Planes',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/pdf-modal.js')],
]);
