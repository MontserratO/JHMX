<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * SIG Mapas con capas de información en visualizador.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>SIG: Mapas</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Mapas</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="visor-sig">
        <div class="container">

            <div class="titulo-sec">
                <h2>Mapas de San Luis Potosí</h2>
            </div>

            <p class="sig-ayuda">
                Pulsa cualquier elemento del mapa para ver su nombre.
            </p>

            <div class="sig-visor"
                 data-base="<?= base_url('capas/Shapes/') ?>"
                 data-capas="<?= e(json_encode($capas, JSON_UNESCAPED_UNICODE)) ?>">

                <!-- Mapa -->
                <div class="sig-mapa" id="map"></div>
                <!-- Panel de capas -->
                <aside class="sig-panel">
                    <div class="sig-panel-cab">
                        <h3><i class="bi bi-layers-half" aria-hidden="true"></i> Capas</h3>
                        <button type="button" class="sig-panel-toggle" id="panelToggle"
                                aria-label="Mostrar u ocultar el panel de capas"
                                title="Ocultar el panel de capas">
                            <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="sig-panel-cuerpo">

                        <!-- Mapa base -->
                        <div class="sig-grupo">
                            <h4>Mapa base</h4>
                            <label class="sig-capa">
                                <input type="radio" name="base" value="calles" checked>
                                <span class="sig-capa-nombre">Calles</span>
                            </label>
                            <label class="sig-capa">
                                <input type="radio" name="base" value="satelite">
                                <span class="sig-capa-nombre">Satélite</span>
                            </label>
                        </div>

                        <?php foreach ($grupos as $grupo => $lista): ?>
                            <div class="sig-grupo">
                                <h4><?= e($grupo) ?></h4>

                                <?php foreach ($lista as $clave => $c): ?>
                                    <label class="sig-capa" data-capa="<?= e($clave) ?>">
                                        <input type="checkbox" value="<?= e($clave) ?>"
                                               <?= $c['activa'] ? 'checked' : '' ?>>
                                        <span class="sig-muestra sig-<?= e($c['tipo']) ?>"
                                              style="<?= $c['relleno'] ? 'background:' . e($c['relleno']) . ';' : '' ?><?= $c['color'] ? 'border-color:' . e($c['color']) . ';' : '' ?>"
                                              aria-hidden="true"></span>
                                        <span class="sig-capa-nombre"><?= e($c['etiqueta']) ?></span>
                                        <span class="sig-cargando" aria-hidden="true"></span>
                                    </label>

                                    <?php if (!empty($c['sub'])): ?>
                                        <ul class="sig-sub">
                                            <?php foreach ($c['sub'] as $etq => $color): ?>
                                                <li>
                                                    <span class="sig-muestra"
                                                          style="background: <?= e($color) ?>; border-color: <?= e($color) ?>;"
                                                          aria-hidden="true"></span>
                                                    <?= e($etq) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </aside>

            </div>

            <p class="sig-nota">
                Fuente de la cartografía base: MapTiler y OpenStreetMap.
            </p>
        </div>
    </section>
</main>