<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Portada del Sistema de Información Geográfica.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Sistema de Información Geográfica</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">SIG</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- ===== Entradilla ===== -->
    <section class="sig-entrada pt-5">
        <div class="container">
            <p class="info-intro" data-aos="fade-up">
                El SIG funciona como una base de datos con información geográfica que se encuentra asociada por un identificador común a los objetos gráficos de un mapa digital.
            </p>
        </div>
    </section>

    <!-- ===== Secciones del SIG ===== -->
    <section class="sig-secciones">
        <div class="container">
            <div class="row justify-content-center gy-4">
                <?php foreach ($secciones as $i => $s): ?>
                    <div class="col-md-6 col-lg-3 d-flex">
                        <a href="<?= base_url($s['ruta']) ?>" class="fuente-card"
                           data-aos="fade-up" data-aos-delay="<?= 100 + $i * 80 ?>">
                            <div class="fuente-icono">
                                <i class="<?= e($s['icono']) ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?= e($s['titulo']) ?></h3>
                            <p class="fuente-desc"><?= e($s['desc']) ?></p>
                            <span class="fuente-accion">
                                Ver <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="container sig-intro">

            <div class="row align-items-center gy-4">
                <div class="col-lg-7" data-aos="fade-right">
                    <p>
                        De esta forma, señalando un objeto se conocen sus atributos, y a la inversa, preguntando por un registro de la base de datos se puede saber su localización en la cartografía.
                    </p>
                    <p>
                        Una de las principales funciones es el manejar los recursos naturales; se requiere tomar decisiones que contemplen aspectos relativos al recurso y al objetivo del manejo, entre otros.
                    </p>
                    <p>
                        Para ello se requiere contar con la información necesaria. Una característica de la información relacionada al recurso, principalmente, es que está ubicada en algún punto de la Tierra, es decir está georeferenciada. Por tanto, es necesario brindar los conocimientos necesarios para ubicar, manejar, analizar y presentar este tipo de información haciendo uso de las últimas herramientas que se disponen: los Sistemas de Información Geográfica y los Sistemas de Posicionamiento Global.
                    </p>
                </div>

                <div class="col-lg-5" data-aos="fade-left">
                    <figure class="sig-mapa">
                        <img src="<?= base_url('img/mapaSLP.png') ?>"
                             alt="Silueta del estado de San Luis Potosí" loading="lazy">
                        <figcaption>San Luis Potosí</figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>
</main>