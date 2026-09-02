<?php

/**
 * Controlador COMPARTIDO de los tres visualizadores.
 */

defined('JH_APP') || exit('Acceso no permitido.');

$def = CatalogoTablas::obtener($clave ?? '');
if ($def === null) {
    http_response_code(404);
    exit('Tabla no encontrada.');
}

$repo = CatalogoTablas::repositorio($clave);

// --- Filtros por faceta (desplegables) ---
$facetasDef = $def['facetas'] ?? [];
$facetasSel = [];
$recibidas  = is_array($_GET['f'] ?? null) ? $_GET['f'] : [];

foreach ($facetasDef as $columna => $etiqueta) {
    $valor = trim((string) ($recibidas[$columna] ?? ''));
    if ($valor !== '') {
        $facetasSel[$columna] = $valor;
    }
}

// --- Parámetros de la consulta, todos validados ---
$params = [
    'order'    => $_GET['order']    ?? '',
    'dir'      => $_GET['dir']      ?? '',
    'filtro'   => $_GET['filtro']   ?? '',
    'busqueda' => trim($_GET['busqueda'] ?? ''),
    'facetas'  => $facetasSel,
];

// Cuántos registros por página. Lista blanca.
$porPagina = (int) ($_GET['n'] ?? 25);
if (!in_array($porPagina, [25, 50, 100], true)) {
    $porPagina = 25;
}

$pagina = max(1, (int) ($_GET['p'] ?? 1));

// --- Consulta ---
$total       = $repo->contarFiltrado($params);
$totalPagina = (int) ceil($total / $porPagina);

if ($totalPagina > 0 && $pagina > $totalPagina) {
    $pagina = $totalPagina;
}

$filas = $repo->all($params, $porPagina, $pagina);

$opcionesFaceta = [];
foreach ($facetasDef as $columna => $etiqueta) {
    $opcionesFaceta[$columna] = $repo->valoresDe($columna);
}

$ordenActual = pick($params['order'], array_keys($def['listado']), '');
$dirActual   = strtolower($params['dir']) === 'desc' ? 'desc' : 'asc';

View::render('base-tabla', [
    'def'         => $def,
    'clave'       => $clave,
    'filas'       => $filas,
    'total'       => $total,
    'pagina'      => $pagina,
    'totalPagina' => $totalPagina,
    'porPagina'   => $porPagina,
    'params'      => $params,
    'ordenActual' => $ordenActual,
    'dirActual'   => $dirActual,
    'facetasDef'  => $facetasDef,
    'facetasSel'  => $facetasSel,
    'opcionesFaceta' => $opcionesFaceta,
], [
    'titulo'      => $def['titulo'] . ' — Base de Datos, Agua en SLP',
    'descripcion' => $def['descripcion'],
    'body_id'     => 'Visor',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/tabla.js')],
]);