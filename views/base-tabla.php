<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Vista compartida por los tres visualizadores.
 */

$url = function (array $cambios) use ($params, $porPagina, $clave, $facetasSel) {
    $q = array_filter([
        'filtro'   => $params['filtro'],
        'busqueda' => $params['busqueda'],
        'order'    => $params['order'],
        'dir'      => $params['dir'],
        'n'        => $porPagina !== 25 ? $porPagina : '',
    ], fn($v) => $v !== '' && $v !== null);

    $q = array_merge($q, $cambios);
    $q = array_filter($q, fn($v) => $v !== '' && $v !== null);

    if ($facetasSel !== []) {
        $q['f'] = $facetasSel;
    }

    return base_url('ElaguaSLP/base/' . $clave) . ($q ? '?' . http_build_query($q) : '');
};

$hayFiltros = $params['busqueda'] !== '' || $facetasSel !== [];

$desde = $total > 0 ? (($pagina - 1) * $porPagina) + 1 : 0;
$hasta = min($pagina * $porPagina, $total);
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>La Gestión del Agua en San Luis Potosí</h1>
        </div>
    </div>
</header>

<main id="main">

    <section id="bread" class="bread">
        <div class="container">
            <nav aria-label="Ruta de navegación">
                <ol class="breadcrumb pt-4">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('ElaguaSLP') ?>">Agua en SLP</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('ElaguaSLP/base') ?>">Base de Datos</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= e($def['titulo']) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="visor">
        <div class="container">

            <div class="titulo-sec">
                <h2><?= e($def['titulo']) ?></h2>
            </div>

            <p class="visor-intro"><?= e($def['intro'] ?? $def['descripcion']) ?></p>

            <!-- ===== Buscador ===== -->
            <form class="visor-busca" method="get" action="<?= base_url('ElaguaSLP/base/' . $clave) ?>">
                <div class="visor-busca-campos">
                    <label class="visually-hidden" for="filtro">Buscar en</label>
                    <select name="filtro" id="filtro" class="visor-select">
                        <option value="General">Todos los campos</option>
                        <?php foreach ($def['buscar'] as $col): ?>
                            <option value="<?= e($col) ?>"
                                <?= $params['filtro'] === $col ? 'selected' : '' ?>>
                                <?= e($def['detalle'][$col] ?? $col) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label class="visually-hidden" for="busqueda">Término de búsqueda</label>
                    <input type="search" name="busqueda" id="busqueda" class="visor-input"
                           placeholder="Escribe una palabra a buscar…"
                           value="<?= e($params['busqueda']) ?>">

                    <button type="submit" class="btn-a">
                        <i class="bi bi-search" aria-hidden="true"></i> Buscar
                    </button>
                </div>

                <?php if ($facetasDef !== []): ?>
                    <div class="visor-facetas">
                        <?php foreach ($facetasDef as $columna => $etiqueta): ?>
                            <?php
                            $valores = $opcionesFaceta[$columna] ?? [];
                            if ($valores === []) continue;
                            ?>
                            <div class="visor-faceta">
                                <label for="fac-<?= e($columna) ?>"><?= e($etiqueta) ?></label>
                                <select name="f[<?= e($columna) ?>]" id="fac-<?= e($columna) ?>"
                                        class="visor-select-faceta">
                                    <option value="">Todos</option>
                                    <?php foreach ($valores as $valor): ?>
                                        <option value="<?= e($valor) ?>"
                                            <?= (($facetasSel[$columna] ?? '') === $valor) ? 'selected' : '' ?>>
                                            <?= e($valor) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($hayFiltros): ?>
                    <a href="<?= base_url('ElaguaSLP/base/' . $clave) ?>" class="visor-limpiar">
                        <i class="bi bi-x-circle" aria-hidden="true"></i> Quitar todos los filtros
                    </a>
                <?php endif; ?>
            </form>

            <!-- ===== Resumen de resultados ===== -->
            <div class="visor-resumen">
                <p class="visor-conteo">
                    <?php if ($total === 0): ?>
                        Sin resultados
                    <?php else: ?>
                        Mostrando <strong><?= $desde ?>–<?= $hasta ?></strong>
                        de <strong><?= number_format($total) ?></strong>
                        <?= $total === 1 ? 'registro' : 'registros' ?>
                        <?php if ($params['busqueda'] !== ''): ?>
                            para «<?= e($params['busqueda']) ?>»
                        <?php endif; ?>
                        <?php foreach ($facetasSel as $columna => $valor): ?>
                            <span class="visor-chip">
                                <?= e($facetasDef[$columna] ?? $columna) ?>: <?= e($valor) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </p>

                <?php if ($total > 25): ?>
                    <div class="visor-porpagina">
                        <span>Por página:</span>
                        <?php foreach ([25, 50, 100] as $n): ?>
                            <a href="<?= e($url(['n' => $n === 25 ? '' : $n, 'p' => ''])) ?>"
                               class="<?= $porPagina === $n ? 'activo' : '' ?>"><?= $n ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($total === 0): ?>
                <div class="visor-vacio">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <p>No encontramos registros que coincidan con los filtros aplicados.</p>
                    <p class="visor-vacio-tip">
                        Prueba con una palabra más corta, busca en «Todos los campos»
                        o quita alguno de los filtros.
                    </p>
                    <?php if ($hayFiltros): ?>
                        <a href="<?= base_url('ElaguaSLP/base/' . $clave) ?>" class="btn-a mt-3">
                            Quitar filtros
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>

                <!-- ===== Tabla ===== -->
                <div class="visor-tabla-cont">
                    <table class="visor-tabla">
                        <thead>
                            <tr>
                                <?php foreach ($def['listado'] as $col => $etiqueta): ?>
                                    <?php
                                    $esActual = ($ordenActual === $col);
                                    $nuevaDir = ($esActual && $dirActual === 'asc') ? 'desc' : 'asc';
                                    ?>
                                    <th scope="col" <?= $esActual ? 'aria-sort="' . ($dirActual === 'asc' ? 'ascending' : 'descending') . '"' : '' ?>>
                                        <a href="<?= e($url(['order' => $col, 'dir' => $nuevaDir, 'p' => ''])) ?>">
                                            <?= e($etiqueta) ?>
                                            <?php if ($esActual): ?>
                                                <i class="bi bi-caret-<?= $dirActual === 'asc' ? 'up' : 'down' ?>-fill" aria-hidden="true"></i>
                                            <?php else: ?>
                                                <i class="bi bi-arrow-down-up orden-inactivo" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        </a>
                                    </th>
                                <?php endforeach; ?>
                                <th scope="col" class="col-accion">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filas as $fila): ?>
                                <?php
                                $campoTit  = $def['campoTitulo'] ?? array_key_first($def['listado']);
                                $campoPral = $def['campoPrincipal'] ?? '';

                                $resto = [];
                                foreach ($def['detalle'] as $col => $etiqueta) {
                                    if ($col === $campoPral) {
                                        continue;
                                    }
                                    $valor = trim((string) ($fila[$col] ?? ''));
                                    if ($valor !== '') {
                                        $resto[$etiqueta] = $valor;
                                    }
                                }

                                $registro = [
                                    'titulo'    => trim((string) ($fila[$campoTit] ?? '')) ?: 'Ficha completa',
                                    'pralLabel' => $def['detalle'][$campoPral] ?? '',
                                    'pral'      => trim((string) ($fila[$campoPral] ?? '')),
                                    'resto'     => $resto,
                                ];
                                ?>
                                <tr>
                                    <?php foreach ($def['listado'] as $col => $etiqueta): ?>
                                        <td data-label="<?= e($etiqueta) ?>">
                                            <?= e((string) ($fila[$col] ?? '')) ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="col-accion" data-label="Detalle">
                                        <button type="button" class="btn-b btn-detalle"
                                                data-bs-toggle="modal" data-bs-target="#modalRegistro"
                                                data-registro="<?= e(json_encode($registro, JSON_UNESCAPED_UNICODE)) ?>">
                                            Ver ficha
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ===== Paginación ===== -->
                <?php if ($totalPagina > 1): ?>
                    <nav class="visor-paginacion" aria-label="Paginación de resultados">
                        <a href="<?= e($url(['p' => max(1, $pagina - 1)])) ?>"
                           class="pag-flecha <?= $pagina <= 1 ? 'inactivo' : '' ?>"
                           <?= $pagina <= 1 ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                            <i class="bi bi-chevron-left" aria-hidden="true"></i> Anterior
                        </a>

                        <?php
                        $ini = max(1, $pagina - 2);
                        $fin = min($totalPagina, $pagina + 2);
                        ?>

                        <?php if ($ini > 1): ?>
                            <a href="<?= e($url(['p' => 1])) ?>">1</a>
                            <?php if ($ini > 2): ?><span class="pag-puntos">…</span><?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $ini; $i <= $fin; $i++): ?>
                            <a href="<?= e($url(['p' => $i])) ?>"
                               class="<?= $i === $pagina ? 'activo' : '' ?>"
                               <?= $i === $pagina ? 'aria-current="page"' : '' ?>><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($fin < $totalPagina): ?>
                            <?php if ($fin < $totalPagina - 1): ?><span class="pag-puntos">…</span><?php endif; ?>
                            <a href="<?= e($url(['p' => $totalPagina])) ?>"><?= $totalPagina ?></a>
                        <?php endif; ?>

                        <a href="<?= e($url(['p' => min($totalPagina, $pagina + 1)])) ?>"
                           class="pag-flecha <?= $pagina >= $totalPagina ? 'inactivo' : '' ?>"
                           <?= $pagina >= $totalPagina ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                            Siguiente <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </a>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </section>
</main>

<!-- ===== Modal de ficha completa ===== -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content ficha-modal">

            <button type="button" class="ficha-cerrar" data-bs-dismiss="modal" aria-label="Cerrar">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>

            <div class="ficha-cabecera">
                <span class="ficha-etiqueta"><?= e($def['titulo']) ?></span>
                <h2 class="ficha-titulo" id="modalRegistroLabel"></h2>
            </div>

            <div class="modal-body">
                <div class="ficha-principal" id="fichaPrincipal">
                    <span class="ficha-principal-label" id="fichaPralLabel"></span>
                    <p class="ficha-principal-texto" id="fichaPralTexto"></p>
                </div>

                <div class="ficha-datos" id="fichaDatos"></div>
            </div>
        </div>
    </div>
</div>