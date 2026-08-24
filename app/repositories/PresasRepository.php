<?php

/**
 * Acceso a la tabla `presas`. Reemplaza a presas.json.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class PresasRepository extends Repository
{
    protected string $table = 'presas';
    protected string $defaultOrder = 'Nombre';

    protected array $columns = [
        'ID', 'Nombre', 'Sobrenombre', 'Localidad', 'Municipio', 'Estado',
        'Capacidad', 'Corriente', 'Cuenca', 'Construccion', 'Dependencia', 'Uso',
    ];

    protected array $fillable = [
        'Nombre', 'Sobrenombre', 'Imagen', 'Fecha', 'Localidad', 'Municipio',
        'Estado', 'Capacidad', 'Corriente', 'Cuenca', 'Construccion',
        'Dependencia', 'Uso', 'Cortina', 'Tipo', 'Longitud', 'Altura', 'Ancho',
        'Obra', 'TipoObra', 'Compuertas', 'LocalizacionObra', 'Medida', 'Gasto',
        'ObraExcedencia', 'Cantidad', 'Agujas', 'LocalizacionAgujas',
        'TipoAgujas', 'LongitudAgujas', 'CargaMax', 'GastoObra',
        'CoordX', 'CoordY',
    ];
}
