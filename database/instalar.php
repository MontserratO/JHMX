<?php

/**
 * Crea la PRIMERA cuenta de administrador.
 */

require_once __DIR__ . '/../app/bootstrap.php';

$cuantos = (int) Database::conn()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

if ($cuantos > 0) {
    http_response_code(403);
    exit('Ya existe al menos una cuenta.');
}

$error = '';
$listo = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $usuario = trim($_POST['usuario'] ?? '');
    $nombre  = trim($_POST['nombre']  ?? '');
    $clave   = $_POST['clave'] ?? '';

    if ($usuario === '' || $nombre === '') {
        $error = 'El usuario y el nombre son obligatorios.';
    } elseif (!preg_match('/^[a-zA-Z0-9._-]{4,60}$/', $usuario)) {
        $error = 'El usuario solo puede llevar letras, números, punto, guion y guion bajo (4 a 60).';
    } elseif (($msg = Auth::validarClave($clave)) !== '') {
        $error = $msg;
    } else {
        Database::conn()->prepare(
            "INSERT INTO usuarios (Usuario, Nombre, Clave, Rol, Activo, CambiarClave)
             VALUES (?, ?, ?, 'administrador', 1, 0)"
        )->execute([$usuario, $nombre, password_hash($clave, PASSWORD_DEFAULT)]);

        $listo = true;
    }
}

View::render('admin/instalar', [
    'error' => $error,
    'listo' => $listo,
], [
    'titulo'  => 'Primera cuenta — Panel',
    'body_id' => 'Login',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
]);
