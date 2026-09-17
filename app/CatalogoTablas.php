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
                           . 'localizadas en el estado de San Luis Potosí. '
                           . 'En la mayoría de los casos se incluyen los datos de ubicación física: '
                           . 'biblioteca y clasificación. '
                           . 'En algunas está disponible en línea uno o más capítulos del texto.',
            'intro'       => 'Se ofrece una guía de tesis de grado y postgrado que han abordado los '
                           . 'distintos usos del agua en San Luis Potosí. '
                           . 'Los criterios de selección han sido los siguientes: tesis presentadas durante '
                           . 'los últimos 20 años, cuando el tema ha adquirido especial relevancia en México; '
                           . 'que aluden al manejo del agua como problema, aunque no sea el tema único o central de '
                           . 'la tesis; que no han sido publicadas y que se han presentado en instituciones locales. '
                           . 'El último criterio obedece a los recursos materiales y humanos disponibles; '
                           . 'en una segunda etapa incluiremos aquellas tesis que cumpliendo '
                           . 'los demás requisitos, se hayan presentado en instituciones de otras entidades '
                           . 'de México e incluso en el extranjero. En algunos casos, el lector encontrará '
                           . 'en línea una parte de los textos, gracias a la gentileza de los autores. '
                           . 'La mayoría de las fichas disponen de los datos de localización en la biblioteca '
                           . 'de la institución donde el trabajo está disponible físicamente.',
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
            'intro'       => 'Esta sección ofrece una guía de notas periodísticas que abordan problemas vinculados '
                           . 'con el agua en el estado de San Luis Potosí, publicadas en diarios locales, que '
                           . 'generalmente no pueden ser consultados fácilmente desde otras partes del país '
                           . 'debido a que circulan solo en la entidad, o incluso solo en la capital del estado. '
                           . 'Están disponibles notas aparecidas a partir del 2000 que pueden buscarse por tema '
                           . '(cualquier palabra que aparezca en el resumen de la nota); diario en la que fueron '
                           . 'publicadas y fecha (mes y año).',
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
            'intro'       => 'Se han registrado leyes, decretos, reglamentos y otro tipo de regulaciones estatales o '
                           . 'comunitarias que hemos localizado en archivos, diarios oficiales y directamente en campo. \n'
                           . 'La regulación para el acceso al agua es un área especialmente significativa para '
                           . 'entender el tipo de relaciones que mantienen entre si los actores involucrados. '
                           . 'En todos los casos ofrecemos los datos para localizar en extenso el documento. '
                           . 'Una buena parte de ellos están también disponibles en las oficinas del proyecto de investigación.',
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