<?php

/**
 * TesisDocumentosRepository.php — Acceso a la tabla `tesis_documentos`.
 *
 * Reemplaza a ElaguaSLP/tesis.json. Es la tesis CON PDF descargable.
 * No confundir con TesisRepository, que maneja la tabla `tesis` del
 * catálogo bibliográfico: son datos distintos y tablas separadas.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class TesisDocumentosRepository extends Repository
{
    protected string $table = 'tesis_documentos';
    protected string $defaultOrder = 'Autor';

    protected array $columns  = ['ID', 'Titulo', 'Autor', 'Nivel', 'Ruta', 'Orden'];
    protected array $fillable = ['Titulo', 'Autor', 'Nivel', 'Ruta', 'Orden'];
}
