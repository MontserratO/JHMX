<?php

/**
 * Gestión de las cuentas del panel.
 */

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requerir('administrador');

$yo  = Auth::usuario();
$db  = Database::conn();

$mensaje  = '';
$error    = '';
$claveNueva = '';
$accion   = $_GET['accion'] ?? 'lista';
$id       = (int) ($_GET['id'] ?? 0);

/** Genera una contraseña temporal. */
function clave_temporal(): string
{
    $abc = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $out = '';
    for ($i = 0; $i < 14; $i++) {
        $out .= $abc[random_int(0, strlen($abc) - 1)];
    }
    return $out;
}

/** Regresa la cantidad de administradores activos. */
function admins_activos(PDO $db): int
{
    return (int) $db->query(
        "SELECT COUNT(*) FROM usuarios WHERE Rol = 'administrador' AND Activo = 1"
    )->fetchColumn();
}

/* =====================================================================
 *  ACCIONES
 * ===================================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $que = $_POST['que'] ?? '';

    // ---------- Crear cuenta ----------
    if ($que === 'crear') {
        $usuario = trim($_POST['usuario'] ?? '');
        $nombre  = trim($_POST['nombre']  ?? '');
        $correo  = trim($_POST['correo']  ?? '');
        $rol     = ($_POST['rol'] ?? 'editor') === 'administrador' ? 'administrador' : 'editor';

        if ($nombre === '' || $usuario === '') {
            $error = 'El nombre y el usuario son obligatorios.';
        } elseif (!preg_match('/^[a-zA-Z0-9._-]{4,60}$/', $usuario)) {
            $error = 'El usuario solo admite letras, números, punto, guion y guion bajo (4 a 60 caracteres).';
        } elseif ($correo !== '' && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = 'El correo no tiene un formato válido.';
        } else {
            $existe = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE Usuario = ?");
            $existe->execute([$usuario]);

            if ((int) $existe->fetchColumn() > 0) {
                $error = 'Ya existe una cuenta con ese usuario.';
            } else {
                $temporal = clave_temporal();

                $db->prepare(
                    "INSERT INTO usuarios (Usuario, Nombre, Correo, Clave, Rol, Activo, CambiarClave)
                     VALUES (?, ?, ?, ?, ?, 1, 1)"
                )->execute([
                    $usuario, $nombre, ($correo !== '' ? $correo : null),
                    password_hash($temporal, PASSWORD_DEFAULT), $rol,
                ]);

                Auth::bitacora('creó una cuenta', 'usuarios', $usuario, $nombre . ' (' . $rol . ')');

                $claveNueva = $temporal;
                $mensaje    = 'Cuenta creada para ' . $nombre . '.';
            }
        }
        $accion = ($error !== '') ? 'nuevo' : 'lista';
    }

    // ---------- Editar cuenta ----------
    if ($que === 'editar') {
        $idEd   = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $rol    = ($_POST['rol'] ?? 'editor') === 'administrador' ? 'administrador' : 'editor';

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$idEd]);
        $u = $stmt->fetch();

        if ($u === false) {
            $error = 'Esa cuenta no existe.';
        } elseif ($nombre === '') {
            $error = 'El nombre es obligatorio.';
        } elseif ($correo !== '' && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = 'El correo no tiene un formato válido.';
        } elseif ($idEd === (int) $yo['id'] && $rol !== 'administrador') {
            $error = 'No puedes quitarte a ti misma el rol de administrador.';
        } elseif ($u['Rol'] === 'administrador' && $rol !== 'administrador'
                  && admins_activos($db) <= 1) {
            $error = 'No se puede dejar el sistema sin ningún administrador activo.';
        } else {
            $db->prepare(
                "UPDATE usuarios SET Nombre = ?, Correo = ?, Rol = ? WHERE ID = ?"
            )->execute([$nombre, ($correo !== '' ? $correo : null), $rol, $idEd]);

            Auth::bitacora('editó una cuenta', 'usuarios', $u['Usuario'], $nombre . ' (' . $rol . ')');
            $mensaje = 'Cuenta actualizada.';
            $accion  = 'lista';
        }
        if ($error !== '') {
            $accion = 'editar';
            $id     = $idEd;
        }
    }

    // ---------- Activar o desactivar ----------
    if ($que === 'estado') {
        $idEd = (int) ($_POST['id'] ?? 0);

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$idEd]);
        $u = $stmt->fetch();

        if ($u === false) {
            $error = 'Esa cuenta no existe.';
        } elseif ($idEd === (int) $yo['id']) {
            $error = 'No puedes desactivar tu propia cuenta.';
        } elseif ($u['Activo'] && $u['Rol'] === 'administrador' && admins_activos($db) <= 1) {
            $error = 'No se puede desactivar al último administrador activo.';
        } else {
            $nuevo = $u['Activo'] ? 0 : 1;
            $db->prepare("UPDATE usuarios SET Activo = ? WHERE ID = ?")->execute([$nuevo, $idEd]);

            Auth::bitacora($nuevo ? 'reactivó una cuenta' : 'desactivó una cuenta',
                           'usuarios', $u['Usuario'], $u['Nombre']);

            $mensaje = $nuevo ? 'Cuenta reactivada.' : 'Cuenta desactivada.';
        }
        $accion = 'lista';
    }

    // ---------- Restablecer contraseña ----------
    if ($que === 'restablecer') {
        $idEd = (int) ($_POST['id'] ?? 0);

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$idEd]);
        $u = $stmt->fetch();

        if ($u === false) {
            $error = 'Esa cuenta no existe.';
        } else {
            $temporal = clave_temporal();

            $db->prepare(
                "UPDATE usuarios SET Clave = ?, CambiarClave = 1 WHERE ID = ?"
            )->execute([password_hash($temporal, PASSWORD_DEFAULT), $idEd]);

            $db->prepare("DELETE FROM intentos_acceso WHERE Usuario = ?")
               ->execute([$u['Usuario']]);

            Auth::bitacora('restableció una contraseña', 'usuarios', $u['Usuario'], $u['Nombre']);

            $claveNueva = $temporal;
            $mensaje    = 'Contraseña restablecida para ' . $u['Nombre'] . '.';
        }
        $accion = 'lista';
    }
}

/* =====================================================================
 *  FORMULARIO
 * ===================================================================== */
if ($accion === 'nuevo' || $accion === 'editar') {

    $cuenta = ['Usuario' => '', 'Nombre' => '', 'Correo' => '', 'Rol' => 'editor'];

    if ($accion === 'editar') {
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$id]);
        $cuenta = $stmt->fetch();

        if ($cuenta === false) {
            http_response_code(404);
            exit('Esa cuenta no existe.');
        }
    }

    if ($error !== '') {
        $cuenta['Usuario'] = $_POST['usuario'] ?? $cuenta['Usuario'];
        $cuenta['Nombre']  = $_POST['nombre']  ?? '';
        $cuenta['Correo']  = $_POST['correo']  ?? '';
        $cuenta['Rol']     = $_POST['rol']     ?? 'editor';
    }

    View::render('admin/usuario-form', [
        'cuenta'  => $cuenta,
        'esNuevo' => ($accion === 'nuevo'),
        'error'   => $error,
        'yo'      => $yo,
    ], [
        'titulo'  => ($accion === 'nuevo' ? 'Nueva cuenta' : 'Editar cuenta') . ' — Panel',
        'body_id' => 'Panel',
        'navbars' => ['navbar-colsan', 'navbar-gen'],
        'css'     => [base_url('assets/css/admin.css')],
    ]);
    exit;
}

/* =====================================================================
 *  LISTADO
 * ===================================================================== */
$cuentas = $db->query(
    "SELECT * FROM usuarios ORDER BY Activo DESC, Rol, Nombre"
)->fetchAll();

View::render('admin/usuarios', [
    'cuentas'    => $cuentas,
    'yo'         => $yo,
    'mensaje'    => $mensaje,
    'error'      => $error,
    'claveNueva' => $claveNueva,
], [
    'titulo'  => 'Cuentas de acceso — Panel',
    'body_id' => 'Panel',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
    'js'      => [base_url('assets/js/admin.js')],
]);
