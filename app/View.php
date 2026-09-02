<?php

/**
 * Motor de plantillas mínimo.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class View
{
    private const VIEWS = __DIR__ . '/../views/';

    public static function render(string $vista, array $datos = [], array $opciones = []): void
    {
        $__opciones = $opciones;

        extract($datos, EXTR_SKIP);

        ob_start();
        require self::VIEWS . $vista . '.php';
        $contenido = ob_get_clean();

        $opciones = $__opciones;
        $titulo   = $opciones['titulo'] ?? 'Justicia Hídrica en México';
        require self::VIEWS . 'layout.php';
    }

    public static function partial(string $nombre, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);
        require self::VIEWS . 'partials/' . $nombre . '.php';
    }
}