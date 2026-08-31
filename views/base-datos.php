<?php defined('JH_APP') || exit('Acceso no permitido.'); 
/**
* Pagina principal de la Base de Datos de El Agua en San Luis Potosí
*/
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Base de Datos</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Base de Datos</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="base-intro">
        <div class="container">
            <p class="info-intro" data-aos="fade-up">
                En esta base de datos hemos organizado una parte de la información disponible sobre
                estudios, conflictos y regulaciones de los usos del agua en San Luis Potosí,
                a partir de tres fuentes:
            </p>

            <div class="row justify-content-center gy-4">
                <?php foreach ($tablas as $i => $t): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <a href="<?= base_url('ElaguaSLP/base/' . $t['clave']) ?>"
                           class="fuente-card"
                           data-aos="fade-up" data-aos-delay="<?= 100 + $i * 100 ?>">
                            <div class="fuente-icono">
                                <i class="bi <?= e($t['icono']) ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?= e($t['titulo']) ?></h3>
                            <p class="fuente-total">
                                <?= number_format($t['total']) ?>
                                <?= $t['total'] === 1 ? 'registro' : 'registros' ?>
                            </p>
                            <p class="fuente-desc"><?= e($t['descripcion']) ?></p>
                            <span class="fuente-accion">
                                Consultar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Créditos de la base de datos -->
    <section class="base-creditos">
        <div class="container">
            <div class="creditos-caja" data-aos="fade-up">
                <p>
                    D.R. La base de datos «La Gestión del Agua en San Luis Potosí» ha sido elaborada
                    por el Programa Agua y Sociedad de El Colegio de San Luis, A.C., con recursos del
                    proyecto FMSLP-2002-4836 CONACYT — Gobierno del Estado de San Luis Potosí.
                </p>
                <dl class="creditos-lista">
                    <dt>Coordinador</dt>
                    <dd>Francisco Peña</dd>

                    <dt>Idea y diseño</dt>
                    <dd>Carlos Núñez · Francisco Peña · Elda Barbosa</dd>

                    <dt>Rediseño y desarrollo</dt>
                    <dd>Montserrat Galván</dd>

                    <dt>Investigación</dt>
                    <dd>Francisco Peña · Germán Santacruz · Rosario Alcalde · Carmen Zetina · Mónica Luna</dd>

                    <dt>Captura</dt>
                    <dd>Carmen Zetina · Mónica Luna · Rosario Alcalde</dd>

                    <dt>Edición</dt>
                    <dd>Francisco Peña</dd>
                </dl>
                <p class="creditos-nota">
                    Agradecemos la colaboración especial de Judith Corpus.
                </p>
            </div>
        </div>
    </section>
</main>