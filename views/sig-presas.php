<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * SIG Mapas de presas de San Luis Potosí.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>SIG: Presas</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Presas</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="sig-mapa-seccion">
        <div class="container">

            <div class="titulo-sec">
                <h2>Principales presas de San Luis Potosí</h2>
            </div>

            <p class="sig-ayuda">
                Pulsa un punto del mapa para ver la ficha técnica de la presa o puedes elegirla en la lista de abajo.
            </p>

            <div class="row gy-4 align-items-center">

                <div class="col-lg-8">
                    <div class="mapa-caja">
                        <div class="mapa-marco mapa-presas" id="mapaCaja"
                             data-svg="<?= base_url('assets/mapa/slp-municipios.svg') ?>">

                            <img class="mapa-base"
                                 src="<?= base_url('img/Mapas/presa.jpg') ?>"
                                 alt="Mapa base de San Luis Potosí con estados vecinos, coordenadas, orientación y escala">

                            <div class="mapa-cargando" id="mapaCargando">
                                <div class="libro-spinner" aria-hidden="true"></div>
                                <p>Cargando el mapa…</p>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">
                    <?php $macro = 'img/Mapas/presaM.jpg'; ?>
                    <?php if (is_file(__DIR__ . '/../' . $macro)): ?>
                        <figure class="mapa-macro">
                            <img src="<?= base_url($macro) ?>"
                                 alt="Ubicación de San Luis Potosí dentro de México" loading="lazy">
                            <figcaption>Macrolocalización</figcaption>
                        </figure>
                    <?php endif; ?>

                    <div class="mapa-leyenda">
                        <h3>Simbología</h3>
                        <ul class="leyenda-lista">
                            <li class="leyenda-conagua">
                                <span class="leyenda-punto" aria-hidden="true"></span>
                                <span>Principales presas de SLP</span>
                            </li>
                            <li class="leyenda-conagua">
                                <span class="leyenda-color zona-estatal" aria-hidden="true"></span>
                                <span>División estatal</span>
                            </li>
                            <li class="leyenda-conagua">
                                <span class="leyenda-color zona-municipal" aria-hidden="true"></span>
                                <span>División municipal</span>
                            </li>
                            <li class="leyenda-conagua">
                                <span class="leyenda-color zona-centroSLP" aria-hidden="true"></span>
                                <span>Zona centro de San Luis Potosí</span>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>

            <!-- Lista de presas. -->
            <div class="presas-lista">
                <h3>Presas registradas <span><?= count($presas) ?></span></h3>
                <!-- Cada presa lleva un número que se repite en su punto del
                     mapa, para poder relacionarlos de un vistazo. Al señalar
                     una de la lista, su punto se resalta. -->
                <div class="presas-chips">
                    <?php $n = 0; ?>
                    <?php foreach ($presas as $p): ?>
                        <?php $ficha = ficha_presa($p); $n++; ?>
                        <button type="button" class="presa-chip"
                                data-bs-toggle="modal" data-bs-target="#modalPresa"
                                data-num="<?= $n ?>"
                                data-nombre="<?= e($p['Nombre']) ?>"
                                data-municipio="<?= e($p['Municipio'] ?? '') ?>"
                                data-imagen="<?= e($p['Imagen'] ? file_url($p['Imagen']) : '') ?>"
                                data-x="<?= e((string) $p['CoordX']) ?>"
                                data-y="<?= e((string) $p['CoordY']) ?>"
                                data-ficha="<?= e(json_encode($ficha, JSON_UNESCAPED_UNICODE)) ?>">
                            <span class="presa-num"><?= $n ?></span>
                            <?= e($p['Nombre']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- ===== Ficha técnica de la presa - modal ===== -->
<div class="modal fade" id="modalPresa" tabindex="-1" aria-labelledby="presaTitulo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content presa-visor" id="presaVisor">

            <img id="presaImagen" class="presa-foto" src="" alt="">

            <div class="presa-barra">
                <div class="presa-identidad">
                    <span class="presa-etiqueta">Presa</span>
                    <h2 class="presa-titulo" id="presaTitulo"></h2>
                    <p class="presa-municipio" id="presaMunicipio"></p>
                </div>
                <div class="presa-controles">
                    <button type="button" class="presa-btn" id="presaAlternar"
                            aria-expanded="true" title="Ocultar los datos para ver la fotografía">
                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                        <span>Ver foto</span>
                    </button>
                    <button type="button" class="presa-btn presa-cerrar" data-bs-dismiss="modal" aria-label="Cerrar">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="presa-panel" id="presaPanel">
                <div class="presa-secciones" id="presaSecciones"></div>
            </div>

            <p class="presa-pista" id="presaPista">Pulsa la imagen para volver a mostrar los datos</p>
        </div>
    </div>
</div>