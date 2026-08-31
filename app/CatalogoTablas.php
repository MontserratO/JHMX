<?php

/**
 *  Definición de las tablas consultables de la base
 * de datos "La Gestión del Agua en San Luis Potosí".
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class CatalogoTablas
{
    private const TABLAS = [

        'tesis' => [
            'titulo'      => 'Tesis de Grado y Posgrado',
            'icono'       => 'bi-mortarboard',
            'repo'        => 'TesisRepository',
            'descripcion' => 'Tesis presentadas durante los últimos diez años en instituciones '
                           . 'localizadas en el estado de San Luis Potosí. En la mayoría de los casos '
                           . 'se incluyen los datos de ubicación física: biblioteca y clasificación. '
                           . 'En algunas está disponible en línea uno o más capítulos del texto.',
            'listado'     => [
                'Autor'        => 'Autor',
                'Titulo'       => 'Título',
                'Institucion'  => 'Institución',
                'Año'          => 'Año',
                'Especialidad' => 'Especialidad',
            ],
            'detalle'     => [
                'Autor'        => 'Autor',
                'Titulo'       => 'Título',
                'LugarEdicion' => 'Lugar de edición',
                'Institucion'  => 'Institución',
                'Año'          => 'Año',
                'DatosColoca'  => 'Datos de colocación',
                'Especialidad' => 'Especialidad',
                'Lugar'        => 'Lugar',
                'SitucionFis'  => 'Situación física',
                'Descripcion'  => 'Descripción',
            ],
            'buscar'      => ['Autor', 'Titulo', 'Institucion', 'Especialidad', 'Lugar'],
        ],

        'prensa' => [
            'titulo'      => 'Noticias Periodísticas',
            'icono'       => 'bi-newspaper',
            'repo'        => 'FichasRepository',
            'descripcion' => 'Guía de noticias relacionadas con el agua, publicadas en los diarios '
                           . 'Pulso de San Luis y La Jornada de San Luis durante los últimos cinco años.',
            'listado'     => [
                'Fecha'      => 'Fecha',
                'Diario'     => 'Diario',
                'Encabezado' => 'Encabezado',
                'Municipio'  => 'Municipio',
                'Proyecto'   => 'Proyecto',
            ],
            'detalle'     => [
                'Proyecto'      => 'Proyecto',
                'Investigador'  => 'Investigador',
                'Municipio'     => 'Municipio',
                'Diario'        => 'Diario',
                'Fecha'         => 'Fecha',
                'Localizacion'  => 'Localización',
                'CveCaptura'    => 'Clave de captura',
                'PalabrasCve'   => 'Palabras clave',
                'Encabezado'    => 'Encabezado',
                'Resumen'       => 'Resumen',
                'Observaciones' => 'Observaciones',
            ],
            'buscar'      => ['Encabezado', 'Diario', 'Municipio', 'PalabrasCve', 'Investigador', 'Proyecto'],
        ],

        'leyes' => [
            'titulo'      => 'Leyes y Reglamentos',
            'icono'       => 'bi-journals',
            'repo'        => 'LeyesRepository',
            'descripcion' => 'Guía de leyes y reglamentos estatales o locales relacionados con el agua. '
                           . 'Algunos de ellos están disponibles físicamente en las oficinas del proyecto.',
            'listado'     => [
                'Titulo'          => 'Título',
                'GeneroDocumento' => 'Tipo de documento',
                'Localidad'       => 'Localidad',
                'Fecha'           => 'Fecha',
                'Numero'          => 'Número',
            ],
            'detalle'     => [
                'Archivo'                => 'Archivo',
                'Localidad'              => 'Localidad',
                'GeneroDocumento'        => 'Tipo de documento',
                'CongresoConstitucional' => 'Congreso constitucional',
                'Numero'                 => 'Número',
                'Titulo'                 => 'Título',
                'Publicacion'            => 'Publicación',
                'Fecha'                  => 'Fecha',
                'DatosColocacion'        => 'Datos de colocación',
                'Descripcion'            => 'Descripción',
            ],
            'buscar'      => ['Titulo', 'GeneroDocumento', 'Localidad', 'Publicacion', 'Descripcion'],
        ],
    ];

    /** Devuelve todas las tablas del catálogo. */
    public static function todas(): array
    {
        return self::TABLAS;
    }

    /** Devuelve la definición de una tabla, o null si el nombre no existe. */
    public static function obtener(string $clave): ?array
    {
        return self::TABLAS[$clave] ?? null;
    }

    /** Crea el repositorio correspondiente a una tabla. */
    public static function repositorio(string $clave): ?Repository
    {
        $def = self::obtener($clave);
        if ($def === null) {
            return null;
        }
        $clase = $def['repo'];
        return new $clase();
    }
}