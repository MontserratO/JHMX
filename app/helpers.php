<?php

/**
 * Funciones de apoyo, sobre todo de seguridad.
 */

defined('JH_APP') || exit('Acceso no permitido.');


/* =========================================================================
 *  ESCAPE DE SALIDA  → mata el XSS (almacenado y reflejado)
 * =========================================================================
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}


/* =========================================================================
 *  CSRF  → protege las operaciones que modifican datos
 * =========================================================================
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Corta la ejecución si el token no coincide. Llamar al inicio de cada POST. */
function csrf_verify(): void
{
    $enviado   = $_POST['csrf_token'] ?? '';
    $esperado  = $_SESSION['csrf_token'] ?? '';

    if (!is_string($enviado) || $esperado === '' || !hash_equals($esperado, $enviado)) {
        http_response_code(419);
        exit('Sesión expirada o petición no válida. Recarga la página e intenta de nuevo.');
    }
}


/* =========================================================================
 *  LISTAS BLANCAS  → mata el SQL Injection de ORDER BY / filtro
 * =========================================================================
 */
function pick(string $value, array $allowed, string $default): string
{
    return in_array($value, $allowed, true) ? $value : $default;
}

function pick_dir(string $dir): string
{
    return strtolower($dir) === 'desc' ? 'DESC' : 'ASC';
}


/* =========================================================================
 *  UTILIDADES
 * ========================================================================= */

/** Construye una URL respetando la subcarpeta del sitio. */
function base_url(string $path = ''): string
{
    return rtrim($GLOBALS['config']['base_path'], '/') . '/' . ltrim($path, '/');
}

/**
 * Construye una URL de archivo respetando la subcarpeta del sitio y codificando los tramos.
 */
function file_url(string $path): string
{
    $tramos = array_map('rawurlencode', explode('/', ltrim($path, '/')));
    return base_url(implode('/', $tramos));
}

/** Redirige y termina. */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}