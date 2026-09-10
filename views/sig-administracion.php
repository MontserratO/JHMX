<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * SIG Mapas de Zonas económicas y regiones administrativas.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>SIG: Administración de Agua</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Administración del agua</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="sig-mapa-seccion">
        <div class="container">

            <div class="titulo-sec">
                <h2>Zonas económicas de San Luis Potosí y regiones administrativas de agua</h2>
            </div>

            <p class="sig-ayuda">
                Pasa el cursor por un municipio para ver su información.
            </p>

            <div class="row gy-4 align-items-start">

                <!-- Mapa -->
                <div class="col-lg-8">
                    <div class="mapa-caja">
                        <div class="mapa-marco" id="mapaCaja"
                             data-svg="<?= base_url('assets/mapa/slp-municipios.svg') ?>"
                             data-imgbase="<?= base_url('img/Municipios/') ?>">

                            <img class="mapa-base"
                                 src="<?= base_url('img/Mapas/ZonaSLP.jpg') ?>"
                                 alt="Mapa base de San Luis Potosí con estados vecinos, coordenadas, orientación y escala">

                            <div class="mapa-cargando" id="mapaCargando">
                                <div class="libro-spinner" aria-hidden="true"></div>
                                <p>Cargando el mapa…</p>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">

                    <div class="mapa-ficha" id="mapaFicha">
                        <img src="<?= base_url('img/Municipios/SLP.jpeg') ?>"
                             id="fichaImagen" alt="" loading="lazy">
                        <div class="mapa-ficha-texto">
                            <h4 id="fichaNombre">San Luis Potosí</h4>
                            <p><span class="ficha-etiqueta">Zona</span> <span id="fichaZona">Centro</span></p>
                        </div>
                    </div>

                    <?php
                    $macro = 'img/Mapas/macrolocalizacion.png';
                    ?>
                    <?php if (is_file(__DIR__ . '/../' . $macro)): ?>
                        <figure class="mapa-macro">
                            <img src="<?= base_url($macro) ?>"
                                 alt="Ubicación de San Luis Potosí dentro de México" loading="lazy">
                            <figcaption>Macrolocalización</figcaption>
                        </figure>
                    <?php endif; ?>
                </aside>
            </div>

            <div class="mapa-leyenda">
                <h3>Simbología</h3>
                <ul>
                    <?php foreach ($zonas as $clave => $etiqueta): ?>
                        <li>
                            <button type="button" class="leyenda-item" data-zona="<?= e($clave) ?>">
                                <span class="leyenda-color zona-<?= e($clave) ?>" aria-hidden="true"></span>
                                <span><?= e($etiqueta) ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                    <li class="leyenda-conagua">
                        <span class="leyenda-linea" aria-hidden="true"></span>
                        <span>División de la CONAGUA para la administración del agua</span>
                    </li>
                </ul>
            </div>

        </div>
    </section>
</main>