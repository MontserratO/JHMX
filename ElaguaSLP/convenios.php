<?php

/**
 * Página estática de convenios.
 */

require_once __DIR__ . '/../app/bootstrap.php';

View::render('documento', [
    'encabezado'  => 'Convenios',
    'documento'   => 'Estudio Integral (COLSAN, IPICYT, CEA)',
    'archivo'     => 'doc/COLSAN-IPICYT-CEA-ESTUDIO INTEGRAL.pdf',
], [
    'titulo'      => 'Convenios — Agua en San Luis Potosí',
    'body_id'     => 'Documento',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/visor-libro.js')],
]);