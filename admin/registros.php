<?php

/**
 * Alta, edición y baja de los registros de la base de datos.
 */

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requerir();

$clave = $_GET['t'] ?? '';
$def   = CatalogoTablas::obtener($clave);

if ($def === null) {
    http_response_code(404);
    exit('Tabla no encontrada.');
}

$repo = CatalogoTablas::repositorio($clave);

$campos = $def['detalle'];

$mensaje = '';
$error   = '';
$accion  = $_GET['accion'] ?? 'lista';
$id      = (int) ($_GET['id'] ?? 0);

/* =====================================================================
 *  ACCIONES
 * ===================================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $que = $_POST['que'] ?? '';

    // ---------- Eliminar ----------
    if ($que === 'eliminar') {
        $idBorrar = (int) ($_POST['id'] ?? 0);
        $registro = $repo->find($idBorrar);

        if ($registro === null) {
            $error = 'Ese registro ya no existe.';
        } else {
            $repo->delete($idBorrar);

            $ref = $registro[$def['campoTitulo'] ?? 'ID'] ?? $idBorrar;
            Auth::bitacora('eliminó', $def['titulo'], (string) $idBorrar,
                           mb_substr((string) $ref, 0, 200));

            $mensaje = 'Registro eliminado.';
        }
        $accion = 'lista';
    }

    // ---------- Crear o actualizar ----------
    if ($que === 'guardar') {
        $datos = [];
        foreach ($campos as $col => $etiqueta) {
            $datos[$col] = trim((string) ($_POST['c_' . $col] ?? ''));
        }

        $campoTit = $def['campoTitulo'] ?? array_key_first($campos);
        if (($datos[$campoTit] ?? '') === '') {
            $error  = 'El campo «' . ($campos[$campoTit] ?? $campoTit) . '» es obligatorio.';
            $accion = ($id > 0) ? 'editar' : 'nuevo';
        } else {
            $idGuardar = (int) ($_POST['id'] ?? 0);

            if ($idGuardar > 0) {
                $repo->update($idGuardar, $datos);
                Auth::bitacora('editó', $def['titulo'], (string) $idGuardar,
                               mb_substr($datos[$campoTit], 0, 200));
                $mensaje = 'Cambios guardados.';
            } else {
                $repo->create($datos);
                $nuevoId = (int) Database::conn()->lastInsertId();
                Auth::bitacora('creó', $def['titulo'], (string) $nuevoId,
                               mb_substr($datos[$campoTit], 0, 200));
                $mensaje = 'Registro agregado.';
            }
            $accion = 'lista';
        }
    }
}

/* =====================================================================
 *  FORMULARIO
 * ===================================================================== */
if ($accion === 'nuevo' || $accion === 'editar') {

    $registro = [];
    if ($accion === 'editar') {
        $registro = $repo->find($id) ?? [];
        if ($registro === []) {
            http_response_code(404);
            exit('Ese registro no existe.');
        }
    }

    if ($error !== '') {
        foreach ($campos as $col => $etiqueta) {
            $registro[$col] = $_POST['c_' . $col] ?? '';
        }
        $registro['ID'] = $_POST['id'] ?? $id;
    }

    View::render('admin/registro-form', [
        'def'      => $def,
        'clave'    => $clave,
        'campos'   => $campos,
        'registro' => $registro,
        'esNuevo'  => ($accion === 'nuevo'),
        'error'    => $error,
    ], [
        'titulo'  => ($accion === 'nuevo' ? 'Nuevo registro' : 'Editar registro') . ' — ' . $def['titulo'],
        'body_id' => 'Panel',
        'navbars' => ['navbar-colsan', 'navbar-gen'],
        'css'     => [base_url('assets/css/admin.css')],
    ]);
    exit;
}

/* =====================================================================
 *  LISTADO
 * ===================================================================== */
$params = [
    'order'    => $_GET['order']    ?? '',
    'dir'      => $_GET['dir']      ?? '',
    'filtro'   => $_GET['filtro']   ?? '',
    'busqueda' => trim($_GET['busqueda'] ?? ''),
];

$porPagina = 25;
$pagina    = max(1, (int) ($_GET['p'] ?? 1));

$total       = $repo->contarFiltrado($params);
$totalPagina = (int) ceil($total / $porPagina);
if ($totalPagina > 0 && $pagina > $totalPagina) {
    $pagina = $totalPagina;
}

$filas = $repo->all($params, $porPagina, $pagina);

View::render('admin/registros', [
    'def'         => $def,
    'clave'       => $clave,
    'campos'      => $campos,
    'filas'       => $filas,
    'total'       => $total,
    'pagina'      => $pagina,
    'totalPagina' => $totalPagina,
    'porPagina'   => $porPagina,
    'params'      => $params,
    'mensaje'     => $mensaje,
    'error'       => $error,
], [
    'titulo'  => 'Administrar ' . $def['titulo'] . ' — Panel',
    'body_id' => 'Panel',
    'navbars' => ['navbar-colsan', 'navbar-gen'],
    'css'     => [base_url('assets/css/admin.css')],
    'js'      => [base_url('assets/js/admin.js')],
]);
