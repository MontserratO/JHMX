<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Galería de imágenes, videos y esquemas por proyecto.
 */

// Elementos por diapositiva según el tipo
$porDiapositiva = ['imagen' => 5, 'video' => 4, 'esquema' => 2][$tipo] ?? 5;
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Recursos visuales</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Recursos Visuales</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="recursos">
        <div class="container">

            <!-- Pestañas -->
            <nav class="recursos-tabs" aria-label="Tipo de recurso">
                <?php foreach ($tipos as $clave => $etiqueta): ?>
                    <a href="<?= base_url('ElaguaSLP/imagenes') ?>?t=<?= e($clave) ?>"
                       class="recursos-tab <?= $tipo === $clave ? 'activa' : '' ?>"
                       <?= $tipo === $clave ? 'aria-current="page"' : '' ?>>
                        <?= e($etiqueta) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <?php if (empty($galerias)): ?>
                <p class="text-center text-muted py-5">
                    Aún no hay recursos de este tipo.
                </p>
            <?php endif; ?>

            <?php foreach ($galerias as $nombre => $archivos): ?>
                <?php
                $grupos     = array_chunk($archivos, $porDiapositiva);
                $idCarrusel = 'gal' . preg_replace('/[^a-zA-Z0-9]/', '', $nombre);
                ?>

                <section class="galeria">
                    <div class="titulo-sec">
                        <h2><?= e($nombre) ?></h2>
                    </div>
                    <p class="galeria-conteo">
                        <?= count($archivos) ?>
                        <?= count($archivos) === 1 ? 'elemento' : 'elementos' ?>
                    </p>

                    <div id="<?= e($idCarrusel) ?>" class="carousel slide galeria-carrusel">
                        <div class="carousel-inner">
                            <?php foreach ($grupos as $g => $grupo): ?>
                                <div class="carousel-item <?= $g === 0 ? 'active' : '' ?>">
                                    <div class="mosaico mosaico-<?= count($grupo) ?>">
                                        <?php foreach ($grupo as $k => $item): ?>
                                            <?php
                                            $rutaOriginal = file_url($item['Ruta']);
                                            $carga = $g === 0 ? 'eager' : 'lazy';
                                            ?>
                                            <div class="mosaico-item">
                                                <?php if ($tipo === 'imagen'): ?>
                                                    <button type="button" class="mosaico-btn"
                                                            data-bs-toggle="modal" data-bs-target="#visorRecurso"
                                                            data-clase="imagen"
                                                            data-src="<?= e($rutaOriginal) ?>"
                                                            data-titulo="<?= e($item['Titulo']) ?>">
                                                        <img src="<?= e(thumb_url($item['Ruta'])) ?>"
                                                             alt="<?= e($item['Titulo']) ?>"
                                                             loading="<?= $carga ?>" decoding="async">
                                                        <span class="mosaico-lupa" aria-hidden="true">
                                                            <i class="bi bi-arrows-angle-expand"></i>
                                                        </span>
                                                    </button>

                                                <?php elseif ($tipo === 'video'): ?>
                                                    <?php
                                                    $poster = poster_video($item['Ruta']);
                                                    ?>
                                                    <button type="button" class="mosaico-btn mosaico-video<?= $poster ? ' con-poster' : '' ?>"
                                                            data-bs-toggle="modal" data-bs-target="#visorRecurso"
                                                            data-clase="video"
                                                            data-src="<?= e($rutaOriginal) ?>"
                                                            data-titulo="<?= e($item['Titulo']) ?>">
                                                        <?php if ($poster): ?>
                                                            <img src="<?= e($poster) ?>" alt=""
                                                                 loading="<?= $carga ?>" decoding="async">
                                                        <?php endif; ?>
                                                        <span class="mosaico-play" aria-hidden="true">
                                                            <i class="bi bi-play-fill"></i>
                                                        </span>
                                                        <span class="mosaico-nombre"><?= e($item['Titulo']) ?></span>
                                                    </button>

                                                <?php else: ?>
                                                    <button type="button" class="mosaico-btn mosaico-esquema"
                                                            data-bs-toggle="modal" data-bs-target="#visorRecurso"
                                                            data-clase="libro"
                                                            data-src="<?= e($rutaOriginal) ?>"
                                                            data-titulo="<?= e($item['Titulo']) ?>">
                                                        <canvas class="mosaico-portada"
                                                                data-pdf="<?= e($rutaOriginal) ?>"></canvas>
                                                        <span class="mosaico-icono" aria-hidden="true">
                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                        </span>
                                                        <span class="mosaico-nombre"><?= e($item['Titulo']) ?></span>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($grupos) > 1): ?>
                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#<?= e($idCarrusel) ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#<?= e($idCarrusel) ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>

                            <div class="carousel-indicators">
                                <?php foreach ($grupos as $g => $grupo): ?>
                                    <button type="button" data-bs-target="#<?= e($idCarrusel) ?>"
                                            data-bs-slide-to="<?= $g ?>"
                                            class="<?= $g === 0 ? 'active' : '' ?>"
                                            aria-label="Grupo <?= $g + 1 ?>"></button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>

        </div>
    </section>
</main>

<!-- ===== Visor modal único ===== -->
<div class="modal fade" id="visorRecurso" tabindex="-1" aria-labelledby="visorTitulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered visor-dialogo">
        <div class="modal-content visor-recurso">

            <button type="button" class="visor-cerrar" data-bs-dismiss="modal" aria-label="Cerrar">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>

            <div class="visor-cuerpo" id="visorCuerpo"></div>

            <p class="visor-pie" id="visorTitulo"></p>
        </div>
    </div>
</div>