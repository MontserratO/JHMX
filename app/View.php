<?php

defined('JH_APP') || exit('Acceso no permitido.');

final class View
{
    private const VIEWS = __DIR__ . '/../views/';

    /** Renderiza una vista dentro del layout y la manda al navegador. */
    public static function render(string $vista, array $datos = [], array $opciones = []): void
    {
        // Las claves de $datos quedan como variables dentro de la vista.
        extract($datos, EXTR_SKIP);

        // Capturamos el HTML de la vista en $contenido...
        ob_start();
        require self::VIEWS . $vista . '.php';
        $contenido = ob_get_clean();

        // ...y lo envolvemos con el layout (que usa $contenido, $titulo, $opciones).
        $titulo   = $opciones['titulo'] ?? 'Justicia Hídrica en México';
        require self::VIEWS . 'layout.php';
    }

    /** Inserta un fragmento reutilizable (barra, pie, etc.). */
    public static function partial(string $nombre, array $datos = []): void
    {
        extract($datos, EXTR_SKIP);
        require self::VIEWS . 'partials/' . $nombre . '.php';
    }
}
