<?php

/**
 * Tablero del panel.
 */

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requerir();

$usuario = Auth::usuario();

$resumen = [];
foreach (CatalogoTablas::todas() as $clave => $def) {
    $repo = CatalogoTablas::repositorio($clave);
    $resumen[] = [
        'clave'  => $clave,
        'titulo' => $def['titulo'],
        'icono'  => $def['icono'],
        'total'  => $repo ? $repo->contar() : 0,
    ];
}

// Últimos movimientos, solo para administradores
$movimientos = [];
if (Auth::esAdmin()) {
    $stmt = Database::conn()->prepare(
        "SELECT * FROM bitacora ORDER BY Momento DESC LIMIT 8"
    );
    $stmt->execute();
    $movimientos = $stmt->fetchAll();
}

View::render('admin/tablero', [
    'usuario'     => $usuario,
    'resumen'     => $resumen,
    'movimientos' => $movimientos,
], [
    'titulo'  => 'Panel de administración — Justicia Hídrica México',
    'body_id' => 'Panel',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
]);
