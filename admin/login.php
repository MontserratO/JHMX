<?php

/**
 * Entrada al panel de administracion.
 */

require_once __DIR__ . '/../app/bootstrap.php';

if (Auth::activo()) {
    redirect(base_url('admin/'));
}

$error  = '';
$volver = $_GET['volver'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    [$ok, $error] = Auth::entrar(
        $_POST['usuario'] ?? '',
        $_POST['clave']   ?? ''
    );

    if ($ok) {
        $destino = base_url('admin/');
        $pedido  = $_POST['volver'] ?? '';
        if ($pedido !== '' && str_starts_with($pedido, base_url('admin'))) {
            $destino = $pedido;
        }
        redirect($destino);
    }
}

View::render('admin/login', [
    'error'  => $error,
    'volver' => $volver,
], [
    'titulo'  => 'Acceso al panel — Justicia Hídrica México',
    'body_id' => 'Login',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
]);
