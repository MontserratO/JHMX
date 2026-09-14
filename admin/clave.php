<?php

/**
 * Cambiar la propia contraseña.
 */

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requerir();

$usuario  = Auth::usuario();
$error    = '';
$listo    = false;
$obligado = $usuario['cambiar'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $actual  = $_POST['actual']  ?? '';
    $nueva   = $_POST['nueva']   ?? '';
    $repetir = $_POST['repetir'] ?? '';

    $stmt = Database::conn()->prepare("SELECT Clave FROM usuarios WHERE ID = ?");
    $stmt->execute([$usuario['id']]);
    $hash = $stmt->fetchColumn();

    if (!password_verify($actual, (string) $hash)) {
        $error = 'La contraseña actual no es correcta.';
    } elseif ($nueva !== $repetir) {
        $error = 'La nueva contraseña y su confirmación no coinciden.';
    } elseif ($nueva === $actual) {
        $error = 'La nueva contraseña debe ser distinta de la actual.';
    } elseif (($msg = Auth::validarClave($nueva)) !== '') {
        $error = $msg;
    } else {
        Auth::cambiarClave((int) $usuario['id'], $nueva);
        $listo = true;
        $obligado = false;
    }
}

View::render('admin/clave', [
    'error'    => $error,
    'listo'    => $listo,
    'obligado' => $obligado,
], [
    'titulo'  => 'Cambiar contraseña — Panel',
    'body_id' => 'Panel',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
]);
