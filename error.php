<?php

/**
 * error.php — Página de error.
 */

require_once __DIR__ . '/app/bootstrap.php';

$mensajes = [
    400 => ['Solicitud incorrecta',   'La petición no se pudo interpretar. Revisa la dirección e inténtalo de nuevo.'],
    403 => ['Acceso restringido',     'No tienes permiso para ver este contenido.'],
    404 => ['Página no encontrada',   'La página que buscas no existe o cambió de dirección.'],
    500 => ['Error del servidor',     'Ocurrió un problema de nuestro lado. Estamos trabajando para resolverlo.'],
    503 => ['Servicio no disponible', 'El sitio está temporalmente fuera de servicio. Vuelve a intentarlo en unos minutos.'],
];

$codigo = (int) ($_GET['codigo'] ?? $_SERVER['REDIRECT_STATUS'] ?? 404);
if (!isset($mensajes[$codigo])) {
    $codigo = 404;
}

[$titulo, $texto] = $mensajes[$codigo];

http_response_code($codigo);

View::render('error', [
    'codigo'  => $codigo,
    'encabez' => $titulo,
    'texto'   => $texto,
], [
    'titulo'      => $titulo . ' — Justicia Hídrica México',
    'descripcion' => $texto,
    'body_id'     => 'Error',
    'navbars'     => ['navbar-colsan', 'navbar-gen'],
]);