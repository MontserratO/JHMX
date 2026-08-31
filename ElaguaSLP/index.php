<?php

/**
 * Portada del subsistema "Agua y comunidades en SLP".
 */

require_once __DIR__ . '/../app/bootstrap.php';

$galeriasRepo = new GaleriasRepository();
$galerias     = $galeriasRepo->porTipo('imagen');

// Fotos de esa galería. Si no existe, la página funciona igual (sin rotación).
$archivos = $galerias['Agua en San Luis Potosí'] ?? [];
$imagenes = array_map(fn($a) => base_url($a['Ruta']), $archivos);

View::render('elagua-slp', [
    'imagenes' => $imagenes,
], [
    'titulo'      => 'Agua y comunidades en San Luis Potosí — Justicia Hídrica México',
    'descripcion' => 'Proyecto de investigación sobre los usos y la gestión del agua en San Luis Potosí durante el último siglo.',
    'body_id'     => 'AguaSLP',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/fondo.js')],
]);
