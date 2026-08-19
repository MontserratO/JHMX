<?php

/**
 * index.php — Página principal del sitio.
 *
 * Los datos vienen de la BASE DE DATOS, no de archivos:
 *   - Imágenes del fondo rotativo → tabla `portada`
 *     (antes se leían del disco con glob(), sin poder ordenarlas,
 *      desactivarlas ni ponerles texto alternativo)
 *   - Noticias vigentes           → tabla `noticias`
 *     (antes se leía noticias.json y se filtraba en PHP)
 */

require_once __DIR__ . '/app/bootstrap.php';

$portadaRepo  = new PortadaRepository();
$noticiasRepo = new NoticiasRepository();

// Imágenes activas de portada, en su orden.
$imagenes = $portadaRepo->activas();

// Noticias cuya vigencia incluye el día de hoy (lo resuelve la consulta SQL).
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
        base_url('assets/js/home.js'),
    ],
]);