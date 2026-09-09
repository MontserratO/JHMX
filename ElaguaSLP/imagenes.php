<?php

/**
 * Pagina estatica de recursos visuales: imágenes, videos y esquemas.
 */

require_once __DIR__ . '/../app/bootstrap.php';

$tipos = [
    'imagen'  => 'Imágenes',
    'video'   => 'Videos',
    'esquema' => 'Esquemas',
];

$tipo = $_GET['t'] ?? 'imagen';
if (!isset($tipos[$tipo])) {
    $tipo = 'imagen';
}

$repo     = new GaleriasRepository();
$galerias = $repo->porTipo($tipo);

View::render('recursos', [
    'tipos'    => $tipos,
    'tipo'     => $tipo,
    'galerias' => $galerias,
], [
    'titulo'      => 'Recursos visuales — Agua en San Luis Potosí',
    'descripcion' => 'Fotografías, videos y esquemas de los proyectos de investigación sobre el agua en San Luis Potosí.',
    'body_id'     => 'Recursos',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => $tipo === 'esquema'
        ? [
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js',
            base_url('assets/js/visor-libro.js'),
            base_url('assets/js/galeria.js'),
          ]
        : [base_url('assets/js/galeria.js')],
]);