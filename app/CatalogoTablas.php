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
            'intro'       => 'Esta sección reúne las tesis de grado y posgrado que abordan el agua '
                           . 'en San Luis Potosí, presentadas en instituciones del estado durante los '
                           . 'últimos diez años. Cada registro incluye los datos bibliográficos y, en '
                           . 'la mayoría de los casos, la ubicación física del ejemplar: biblioteca y '
                           . 'clasificación. Pueden buscarse por autor, título, institución, '
                           . 'especialidad o cualquier palabra que aparezca en la descripción.',
            'campoTitulo'    => 'Titulo',
            'campoPrincipal' => 'Descripcion',
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
            'facetas'     => [
                'Institucion'  => 'Institución',
                'Especialidad' => 'Especialidad',
                'Año'          => 'Año',
            ],
        ],

        'prensa' => [
            'titulo'      => 'Noticias Periodísticas',
            'icono'       => 'bi-newspaper',
            'repo'        => 'FichasRepository',
            'descripcion' => 'Guía de noticias relacionadas con el agua, publicadas en los diarios '
                           . 'Pulso de San Luis y La Jornada de San Luis durante los últimos cinco años.',
            'intro'       => 'Esta sección ofrece una guía de notas periodísticas que abordan problemas '
                           . 'vinculados con el agua en el estado de San Luis Potosí, publicadas en diarios '
                           . 'locales que generalmente no pueden consultarse con facilidad desde otras partes '
                           . 'del país, ya que circulan solo en la entidad o incluso solo en la capital del '
                           . 'estado. Están disponibles notas aparecidas a partir del año 2000, que pueden '
                           . 'buscarse por tema (cualquier palabra que aparezca en el resumen de la nota), '
                           . 'por diario y por fecha.',
            'campoTitulo'    => 'Encabezado',
            'campoPrincipal' => 'Resumen',
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
            'facetas'     => [
                'Diario'    => 'Diario',
                'Municipio' => 'Municipio',
            ],
        ],

        'leyes' => [
            'titulo'      => 'Leyes y Reglamentos',
            'icono'       => 'bi-journals',
            'repo'        => 'LeyesRepository',
            'descripcion' => 'Guía de leyes y reglamentos estatales o locales relacionados con el agua. '
                           . 'Algunos de ellos están disponibles físicamente en las oficinas del proyecto.',
            'intro'       => 'Esta sección reúne leyes, reglamentos y disposiciones estatales o locales '
                           . 'relacionadas con el agua en San Luis Potosí. Cada registro indica el tipo de '
                           . 'documento, la localidad, la fecha y los datos de publicación; algunos ejemplares '
                           . 'están disponibles físicamente en las oficinas del proyecto. Pueden buscarse por '
                           . 'título, tipo de documento, localidad o cualquier palabra de la descripción.',
            'campoTitulo'    => 'Titulo',
            'campoPrincipal' => 'Descripcion',
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
            'facetas'     => [
                'GeneroDocumento' => 'Tipo de documento',
                'Localidad'       => 'Localidad',
            ],
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