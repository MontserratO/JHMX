<?php

/**
 * Acceso a la tabla `fichas` de la bd
 */
defined('JH_APP') || exit('Acceso no permitido.');

final class FichasRepository extends Repository
{
    protected string $table = 'fichas';

    protected string $defaultOrder = 'Fecha';

    protected array $columns = [
        'ID', 'Proyecto', 'Investigador', 'Municipio', 'Diario', 'Fecha',
        'Localizacion', 'CveCaptura', 'PalabrasCve', 'Encabezado', 'Resumen', 'Observaciones',
    ];

    protected array $fillable = [
        'Proyecto', 'Investigador', 'Municipio', 'Diario', 'Fecha',
        'Localizacion', 'CveCaptura', 'PalabrasCve', 'Encabezado', 'Resumen', 'Observaciones',
    ];
}
