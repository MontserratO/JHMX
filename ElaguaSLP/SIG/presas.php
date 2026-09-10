<?php

/**
 * Pagina estatica de SIG de presas de San Luis Potosí.
 */

require_once __DIR__ . '/../../app/bootstrap.php';

$repo = new PresasRepository();

$presas = array_filter(
    $repo->all(['order' => 'Nombre', 'dir' => 'asc']),
    fn($p) => $p['CoordX'] !== null && $p['CoordY'] !== null
);

function ficha_presa(array $p): array
{
    $secciones = [
        'Datos generales' => [
            'Fecha de la visita' => $p['Fecha'],
            'Sobrenombre'        => $p['Sobrenombre'],
            'Localidad'          => $p['Localidad'],
            'Municipio'          => $p['Municipio'],
            'Estado'             => $p['Estado'],
            'Capacidad'          => $p['Capacidad'],
            'Corriente'          => $p['Corriente'],
            'Cuenca hidrológica' => $p['Cuenca'],
            'Construcción'       => $p['Construccion'],
            'Dependencia'        => $p['Dependencia'],
            'Uso'                => $p['Uso'],
        ],
        'Cortina' => [
            'Cortina'  => $p['Cortina'],
            'Tipo'     => $p['Tipo'],
            'Longitud' => $p['Longitud'],
            'Altura'   => $p['Altura'],
            'Ancho'    => $p['Ancho'],
        ],
        'Obra de toma' => [
            'Obra'         => $p['Obra'],
            'Tipo'         => $p['TipoObra'],
            'Compuertas'   => $p['Compuertas'],
            'Localización' => $p['LocalizacionObra'],
            'Medida'       => $p['Medida'],
            'Gasto'        => $p['Gasto'],
        ],
        'Obra de excedencia' => [
            'Obra'         => $p['ObraExcedencia'],
            'Cantidad'     => $p['Cantidad'],
            'Agujas'       => $p['Agujas'],
            'Localización' => $p['LocalizacionAgujas'],
            'Tipo'         => $p['TipoAgujas'],
            'Longitud'     => $p['LongitudAgujas'],
            'Carga máxima' => $p['CargaMax'],
            'Gasto'        => $p['GastoObra'],
        ],
    ];

    foreach ($secciones as $titulo => $campos) {
        $campos = array_filter($campos, fn($v) => trim((string) $v) !== '');
        if ($campos === []) {
            unset($secciones[$titulo]);
        } else {
            $secciones[$titulo] = $campos;
        }
    }

    return $secciones;
}

View::render('sig-presas', [
    'presas' => $presas,
], [
    'titulo'      => 'Presas — SIG, Agua en San Luis Potosí',
    'descripcion' => 'Ubicación y ficha técnica de las principales presas de San Luis Potosí.',
    'body_id'     => 'SIGPresas',
    'navbars'     => ['navbar-colsan', 'navbar-sist'],
    'css'         => [base_url('assets/css/elagua.css')],
    'js'          => [base_url('assets/js/mapa-presas.js')],
]);
