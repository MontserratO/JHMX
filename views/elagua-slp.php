<?php defined('JH_APP') || exit('Acceso no permitido.');
/**
* Pagina principal de El Agua en San Luis Potosí
*/
 ?>
 
<header id="header" class="header-rot">
    <div id="background-overlay"></div>

    <div class="container hero-caja-cont">
        <div class="hero-caja">
            <h1>Agua y comunidades en San Luis Potosí</h1>
            <p>
                Bajo este nombre genérico se desarrolla un proyecto de investigación de largo plazo
                que tiene como objetivo registrar y analizar las modificaciones en las formas de uso
                y gestión del agua en San Luis Potosí durante el último siglo.
            </p>
            <a href="#info" class="btn-a">Conoce más</a>
        </div>
    </div>
</header>

<main id="main">

    <!-- Ruta de navegación -->
    <section id="bread" class="bread">
        <div class="container">
            <nav aria-label="Ruta de navegación">
                <ol class="breadcrumb pt-4">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agua en SLP</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Menu de secciones del subsistema -->
    <section id="menuInd" class="menuInd menuSub">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center gy-3">
                <?php
                $secciones = [
                    ['ElaguaSLP/base',      'bi-database',              'Base de Datos'],
                    ['ElaguaSLP/informes',  'bi-collection',            'Informes, Ponencias y Artículos'],
                    ['ElaguaSLP/tesis',     'bi-file-earmark-post',     'Tesis'],
                    ['ElaguaSLP/planes',    'bi-journals',              'Planes y Programas'],
                    ['ElaguaSLP/convenios', 'bi-clipboard2-check',      'Convenios'],
                    ['ElaguaSLP/imagenes',  'bi-images',                'Recursos Visuales'],
                ];
                foreach ($secciones as $i => [$ruta, $icono, $titulo]): ?>
                    <div class="col-6 col-md-4 col-lg-2 tarjeta-menu">
                        <a href="<?= base_url($ruta) ?>" class="card-link">
                            <div class="icon-box h-100" data-aos="fade-up" data-aos-delay="<?= 100 + $i * 60 ?>">
                                <div class="icon"><i class="bi <?= e($icono) ?>"></i></div>
                                <h3 class="tit"><?= e($titulo) ?></h3>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="info" class="info">
        <div class="container">

            <p class="info-intro" data-aos="fade-up">
                Metodológicamente se orienta por explorar la interacción entre dos unidades:
            </p>

            <div class="row justify-content-center gy-3 mb-5 unidades">
                <div class="col-md-6 col-lg-5">
                    <div class="unidad h-100" data-aos="fade-up" data-aos-delay="100">
                        <i class="bi bi-tsunami" aria-hidden="true"></i>
                        <div>
                            <h3>La Cuenca Hidrológica</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="unidad h-100" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-diagram-3" aria-hidden="true"></i>
                        <div>
                            <h3>La Red Institucional Estatal</h3>
                            <p class="sub">dedicada al manejo del agua</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-texto" data-aos="fade-up">
                <p class="parrafo-ancho">
                    Optar por el estudio de una entidad tiene que ver con someter a escrutinio las
                    posibilidades de una política federal que pretende descentralizar la gestión
                    hacia los gobiernos estatales y municipales.
                </p>

                <div class="row gx-4 gy-3 align-items-center">
                    <div class="col-lg-6">
                        <p>
                            Por sus características fisiográficas, económicas, sociales, étnicas y
                            políticas, el estado de San Luis Potosí puede ser considerado un buen
                            referente para el estudio intensivo de las transformaciones en los usos
                            del agua en México.
                        </p>
                        <p class="mb-0">
                            Al igual que el país, San Luis Potosí ofrece un alto contraste
                            fisiográfico y demográfico: un territorio seco donde se concentra la
                            mayor parte de la población estatal y un territorio húmedo,
                            mayoritariamente campesino. La presencia de pueblos Tének, Nahuas y
                            Xi'Oi matiza y enriquece la economía rural y el tipo de manejo de
                            tierras y aguas.
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-0">
                            En San Luis Potosí, como en pocas entidades, se han experimentado en
                            gran escala diversos usos del agua: para la minería; para la industria
                            de la transformación; el experimento agroindustrial, particularmente de
                            caña de azúcar y cítricos; sin faltar el acondicionamiento fallido de
                            tierras tropicales para la agricultura irrigada en el Pujal-Coy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sistema de Información Geográfica -->
    <section id="sig" class="sig section-bg">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="<?= base_url('img/mapa.png') ?>" class="img-fluid"
                         alt="Mapa de México con el estado de San Luis Potosí destacado">
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="titulo-seccion">
                        <h2>Sistema de Información Geográfica</h2>
                    </div>
                    <p class="mb-4 sig-texto">
                        Sistema de gestión de base de datos que permite la manipulación, análisis,
                        modelado y tratamiento simultáneo de datos espaciales y de la información
                        descriptiva conexa, así como representar gráficamente la información geográfica.
                    </p>
                    <a href="<?= base_url('ElaguaSLP/SIG') ?>" class="btn-a">Conoce más</a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Fotos del fondo rotativo -->
<script>
    window.__portada = <?= json_encode(array_values($imagenes ?? []), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>