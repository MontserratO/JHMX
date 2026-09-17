<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Listado administrable de una tabla.
 */

$url = function (array $cambios) use ($params, $clave) {
    $q = array_filter([
        't'        => $clave,
        'filtro'   => $params['filtro'],
        'busqueda' => $params['busqueda'],
        'order'    => $params['order'],
        'dir'      => $params['dir'],
    ], fn($v) => $v !== '' && $v !== null);

    $q = array_filter(array_merge($q, $cambios), fn($v) => $v !== '' && $v !== null);
    return base_url('admin/registros') . '?' . http_build_query($q);
};

$desde = $total > 0 ? (($pagina - 1) * $porPagina) + 1 : 0;
$hasta = min($pagina * $porPagina, $total);
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1><?= e($def['titulo']) ?></h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="panel">
        <div class="container">

            <nav class="panel-ruta" aria-label="Ruta">
                <a href="<?= base_url('admin/') ?>">
                    Panel
                </a>
                <span><?= e($def['titulo']) ?></span>
            </nav>

            <?php if ($mensaje !== ''): ?>
                <p class="panel-aviso ok" role="status">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= e($mensaje) ?>
                </p>
            <?php endif; ?>
            <?php if ($error !== ''): ?>
                <p class="panel-aviso mal" role="alert">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> <?= e($error) ?>
                </p>
            <?php endif; ?>

            <!-- Buscador y alta -->
            <div class="panel-herramientas">
                <form method="get" action="<?= base_url('admin/registros') ?>" class="panel-busca">
                    <input type="hidden" name="t" value="<?= e($clave) ?>">

                    <label class="visually-hidden" for="filtro">Buscar en</label>
                    <select name="filtro" id="filtro">
                        <option value="General">Todos los campos</option>
                        <?php foreach ($def['buscar'] as $col): ?>
                            <option value="<?= e($col) ?>" <?= $params['filtro'] === $col ? 'selected' : '' ?>>
                                <?= e($campos[$col] ?? $col) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label class="visually-hidden" for="busqueda">Término</label>
                    <input type="search" name="busqueda" id="busqueda"
                           placeholder="Buscar…" value="<?= e($params['busqueda']) ?>">

                    <button type="submit" class="btn-a">
                        <i class="bi bi-search" aria-hidden="true"></i> Buscar
                    </button>

                    <?php if ($params['busqueda'] !== ''): ?>
                        <a href="<?= base_url('admin/registros?t=' . e($clave)) ?>" class="btn-b">Limpiar</a>
                    <?php endif; ?>
                </form>

                <a href="<?= e($url(['accion' => 'nuevo'])) ?>" class="btn-a panel-nuevo">
                    <i class="bi bi-plus-lg" aria-hidden="true"></i> Nuevo registro
                </a>
            </div>

            <p class="panel-conteo">
                <?php if ($total === 0): ?>
                    Sin resultados
                <?php else: ?>
                    Mostrando <strong><?= $desde ?>–<?= $hasta ?></strong>
                    de <strong><?= number_format($total) ?></strong>
                <?php endif; ?>
            </p>

            <?php if ($total > 0): ?>
                <div class="panel-tabla-cont">
                    <table class="panel-tabla">
                        <thead>
                            <tr>
                                <?php foreach ($def['listado'] as $col => $etiqueta): ?>
                                    <?php
                                    $esActual = ($params['order'] === $col);
                                    $nuevaDir = ($esActual && strtolower($params['dir']) === 'asc') ? 'desc' : 'asc';
                                    ?>
                                    <th>
                                        <a href="<?= e($url(['order' => $col, 'dir' => $nuevaDir, 'p' => ''])) ?>">
                                            <?= e($etiqueta) ?>
                                            <i class="bi <?= $esActual
                                                ? 'bi-caret-' . (strtolower($params['dir']) === 'desc' ? 'down' : 'up') . '-fill'
                                                : 'bi-arrow-down-up orden-inactivo' ?>" aria-hidden="true"></i>
                                        </a>
                                    </th>
                                <?php endforeach; ?>
                                <th class="col-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filas as $fila): ?>
                                <tr>
                                    <?php foreach ($def['listado'] as $col => $etiqueta): ?>
                                        <td data-label="<?= e($etiqueta) ?>">
                                            <?= e((string) ($fila[$col] ?? '')) ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="col-acciones" data-label="Acciones">
                                        <a href="<?= e($url(['accion' => 'editar', 'id' => $fila['ID']])) ?>"
                                           class="btn-b btn-chico">
                                            <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                                        </a>

                                        <form method="post" action="<?= base_url('admin/registros?t=' . e($clave)) ?>"
                                              class="form-eliminar" data-nombre="<?= e((string) ($fila[$def['campoTitulo'] ?? 'ID'] ?? '')) ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="que" value="eliminar">
                                            <input type="hidden" name="id" value="<?= (int) $fila['ID'] ?>">
                                            <button type="submit" class="btn-peligro btn-chico">
                                                <i class="bi bi-trash" aria-hidden="true"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPagina > 1): ?>
                    <nav class="visor-paginacion" aria-label="Paginación">
                        <a href="<?= e($url(['p' => max(1, $pagina - 1)])) ?>"
                           class="pag-flecha <?= $pagina <= 1 ? 'inactivo' : '' ?>">
                            <i class="bi bi-chevron-left" aria-hidden="true"></i> Anterior
                        </a>
                        <?php
                        $ini = max(1, $pagina - 2);
                        $fin = min($totalPagina, $pagina + 2);
                        for ($i = $ini; $i <= $fin; $i++): ?>
                            <a href="<?= e($url(['p' => $i])) ?>"
                               class="<?= $i === $pagina ? 'activo' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <a href="<?= e($url(['p' => min($totalPagina, $pagina + 1)])) ?>"
                           class="pag-flecha <?= $pagina >= $totalPagina ? 'inactivo' : '' ?>">
                            Siguiente <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </a>
                    </nav>
                <?php endif; ?>

            <?php else: ?>
                <div class="panel-vacio">
                    <i class="bi bi-inbox" aria-hidden="true"></i>
                    <p>No hay registros que coincidan.</p>
                    <a href="<?= e($url(['accion' => 'nuevo'])) ?>" class="btn-a">Agregar el primero</a>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>
