<?php

/**
 * Pagina estática de Tesis, con documento descargable.
 */

require_once __DIR__ . '/../app/bootstrap.php';

$repo  = new TesisDocumentosRepository();
$tesis = $repo->all(['order' => 'Autor', 'dir' => 'asc']);

View::render('tesis', [
    'tesis' => $tesis,
], [
    'titulo'      => 'Tesis — Agua en San Luis Potosí',
    'descripcion' => 'Tesis de licenciatura, maestría y doctorado sobre el agua en San Luis Potosí, con el texto completo disponible.',
    'body_id'     => 'Tesis',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/pdf-modal.js')],
]);
