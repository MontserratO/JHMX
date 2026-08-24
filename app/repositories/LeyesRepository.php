<?php

/**
 * Acceso a la tabla `leyes` de la bd
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class LeyesRepository extends Repository
{
    protected string $table = 'leyes';

    protected string $defaultOrder = 'Titulo';

    protected array $columns = [
        'ID', 'Archivo', 'Localidad', 'GeneroDocumento', 'CongresoConstitucional',
        'Numero', 'Titulo', 'Publicacion', 'Fecha', 'DatosColocacion', 'Descripcion',
    ];

    protected array $fillable = [
        'Archivo', 'Localidad', 'GeneroDocumento', 'CongresoConstitucional',
        'Numero', 'Titulo', 'Publicacion', 'Fecha', 'DatosColocacion', 'Descripcion',
    ];
}
