<?php

/**
 *  Datos para la página principal del sitio.
 */

require_once __DIR__ . '/app/bootstrap.php';

$portadaRepo  = new PortadaRepository();
$noticiasRepo = new NoticiasRepository();

$imagenes = $portadaRepo->activas();

$noticias = $noticiasRepo->vigentes();

View::render('home', [
    'imagenes' => $imagenes,
    'noticias' => $noticias,
], [
    'titulo'      => 'Justicia Hídrica en México',
    'descripcion' => 'Portal de justicia hídrica en México — El Colegio de San Luis.',
    'body_id'     => 'Principal',
    'navbars'     => ['navbar-gob', 'navbar-colsan'],
    'css'         => ['https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css'],
    'js'          => [
        'https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js',
        base_url('assets/js/fondo.js'),
        base_url('assets/js/home.js'),
    ],
]);