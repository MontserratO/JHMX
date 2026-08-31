<?php

/**
 * Portada de la base de datos.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$tablas = [];
foreach (CatalogoTablas::todas() as $clave => $def) {
    $repo = CatalogoTablas::repositorio($clave);
    $def['clave'] = $clave;
    $def['total'] = $repo ? $repo->contar() : 0;
    $tablas[] = $def;
}

View::render('base-datos', [
    'tablas' => $tablas,
], [
    'titulo'      => 'Base de Datos — Agua en San Luis Potosí',
    'descripcion' => 'Base de datos sobre estudios, conflictos y regulaciones de los usos del agua en San Luis Potosí.',
    'body_id'     => 'BaseDatos',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
]);