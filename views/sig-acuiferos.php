<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * SIG Mapas de Crecimiento urbano y acuífero de San Luis Potosí.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>SIG: Acuíferos</h1>
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
                    <li class="breadcrumb-item"><a href="<?= base_url('ElaguaSLP/SIG/') ?>">SIG</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Crecimiento de la ciudad</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="crecimiento">
        <div class="container">

            <div class="titulo-sec">
                <h2>Crecimiento Urbano de la ciudad de San Luis Potosí</h2>
            </div>

            <p class="crec-entrada-2">
                La ciudad se abastece de los acuíferos, correspondientes a la Cuenca Central del Norte y del Golfo Norte, sobre los que se ha extendido su mancha urbana.
            </p>
            <p class="crec-entrada">
                Aqui se presenta esta relación entre 1959 y 2024.
            </p>

            <div class="crec-serie">

                <!-- ===== 1. El acuífero ===== -->
                <article class="crec-bloque" data-aos="fade-up">
                    <div class="crec-num">1</div>
                    <div class="crec-contenido">
                        <h3>Acuiferos del centro de San Luis Potosí</h3>
                        <p>Acuíferos del estado y su relación con los municipios que
                        forman la zona centro.</p>

                        <figure class="crec-figura">
                            <button type="button" class="crec-imagen"
                                    data-bs-toggle="modal" data-bs-target="#visorMapa"
                                    data-src="<?= base_url('img/Mapas/acuiferos.png') ?>"
                                    data-titulo="Acuíferos de San Luis Potosí">
                                <img src="<?= base_url('img/Mapas/acuiferos.png') ?>"
                                     alt="Mapa de los acuíferos de San Luis Potosí" loading="lazy">
                                <span class="crec-lupa" aria-hidden="true">
                                    <i class="bi bi-zoom-in"></i> Ampliar
                                </span>
                            </button>
                        </figure>
                    </div>
                </article>

                <!-- ===== 2. La animación ===== -->
                <article class="crec-bloque" data-aos="fade-up">
                    <div class="crec-num">2</div>
                    <div class="crec-contenido">
                        <h3>Crecimiento urbano en relación con los acuíferos</h3>
                        <p>
                            La animación recorre la expansión de la mancha urbana sobre los acuíferos del centro, hasta los años 2000.
                        </p>

                        <figure class="crec-figura">
                            <?php
                            $video = 'img/Mapas/AnimacionMapa.mp4';
                            $gif   = 'img/Mapas/AnimacionMapa.gif';
                            ?>
                            <?php if (is_file(__DIR__ . '/../' . $video)): ?>
                                <video class="crec-video" controls loop muted playsinline
                                       preload="metadata">
                                    <source src="<?= base_url($video) ?>" type="video/mp4">
                                    <img src="<?= base_url($gif) ?>"
                                         alt="Animación del crecimiento urbano de San Luis Potosí">
                                </video>
                            <?php else: ?>
                                <img class="crec-video" src="<?= base_url($gif) ?>"
                                     alt="Animación del crecimiento urbano de San Luis Potosí" loading="lazy">
                            <?php endif; ?>
                        </figure>
                    </div>
                </article>

                <!-- ===== 3. El detalle por período ===== -->
                <article class="crec-bloque" data-aos="fade-up">
                    <div class="crec-num">3</div>
                    <div class="crec-contenido">
                        <h3>Crecimiento urbano de 1959–2024</h3>
                        <p>Cada color indica cuándo esa superficie pasó a ser urbana.</p>

                        <figure class="crec-figura">
                            <button type="button" class="crec-imagen"
                                    data-bs-toggle="modal" data-bs-target="#visorMapa"
                                    data-src="<?= base_url('img/Mapas/Crecimiento_Urbano_1959-2024.png') ?>"
                                    data-titulo="Crecimiento urbano de San Luis Potosí, 1959–2024">
                                <img src="<?= base_url('img/Mapas/Crecimiento_Urbano_1959-2024.png') ?>"
                                     alt="Mapa detallado del crecimiento urbano de San Luis Potosí entre 1959 y 2024"
                                     loading="lazy">
                                <span class="crec-lupa" aria-hidden="true">
                                    <i class="bi bi-zoom-in"></i> Ampliar
                                </span>
                            </button>
                        </figure>

                        <ol class="crec-tiempo" aria-label="Períodos de crecimiento">
                            <?php foreach ($periodos as $anio => $color): ?>
                                <li>
                                    <span class="crec-color" style="background: <?= e($color) ?>"
                                          aria-hidden="true"></span>
                                    <span class="crec-anio"><?= e($anio) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </article>

            </div>
        </div>
    </section>
</main>

<!-- ===== Visor de mapas ===== -->
<div class="modal fade" id="visorMapa" tabindex="-1" aria-labelledby="visorMapaTitulo" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content visor-mapa">

            <div class="visor-mapa-barra">
                <h2 class="modal-title" id="visorMapaTitulo"></h2>
                <div class="visor-mapa-controles">
                    <button type="button" class="libro-btn" id="mapaMenos" aria-label="Alejar">
                        <i class="bi bi-zoom-out" aria-hidden="true"></i>
                    </button>
                    <span class="visor-mapa-nivel" id="mapaNivel">100%</span>
                    <button type="button" class="libro-btn" id="mapaMas" aria-label="Acercar">
                        <i class="bi bi-zoom-in" aria-hidden="true"></i>
                    </button>
                    <a href="#" class="libro-btn" id="mapaDescarga" download>
                        <i class="bi bi-download" aria-hidden="true"></i>
                        <span class="libro-btn-txt">Descargar</span>
                    </a>
                    <button type="button" class="libro-btn" data-bs-dismiss="modal" aria-label="Cerrar">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="visor-mapa-lienzo" id="mapaLienzo">
                <img id="mapaAmpliado" src="" alt="">
            </div>
        </div>
    </div>
</div>