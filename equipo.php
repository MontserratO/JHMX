<?php

/**
 * equipo.php — Página del equipo de investigación.
 *
 * Los datos vienen de las tablas `equipo`, `equipo_categorias` y la
 * intermedia `equipo_categoria` (antes: equipo.json).
 *
 * porCategorias() devuelve el arreglo ya agrupado y ordenado, listo para
 * pintarse. Como una persona puede pertenecer a varias categorías, aparecerá
 * en cada una de ellas sin estar duplicada en la base.
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
