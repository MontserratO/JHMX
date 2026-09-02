<?php

/**
 * Página estática de Informes, ponencias y articulos.
 */

require_once __DIR__ . '/../app/bootstrap.php';

View::render('documento', [
    'encabezado'  => 'Informes, Ponencias y Artículos',
    'documento'   => 'Estudio Técnico del Acuífero de San Luis Potosí',
    'archivo'     => 'doc/Estudio técnico del acuífero de San Luís Potosí-2.pdf',
], [
    'titulo'      => 'Informes, Ponencias y Artículos — Agua en San Luis Potosí',
    'body_id'     => 'Documento',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/visor-libro.js')],
]);