<?php

/**
 * Acceso a la tabla `tesis` de la bd
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class TesisRepository extends Repository
{
    protected string $table = 'tesis';

    protected string $defaultOrder = 'Autor';

    // Columnas por las que se puede ordenar y buscar.
    protected array $columns = [
        'ID', 'Autor', 'Titulo', 'LugarEdicion', 'Institucion', 'Año',
        'DatosColoca', 'Especialidad', 'Lugar', 'SitucionFis', 'Descripcion',
    ];

    // Columnas que se pueden insertar/editar (todas menos ID, que es automático).
    protected array $fillable = [
        'Autor', 'Titulo', 'LugarEdicion', 'Institucion', 'Año',
        'DatosColoca', 'Especialidad', 'Lugar', 'SitucionFis', 'Descripcion',
    ];
}
