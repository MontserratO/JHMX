<?php defined('JH_APP') || exit('Acceso no permitido.');
/**
* Página principal de Justicia Hídrica México
*/
 ?>
 
<header id="header" class="align-items-center">
    <div id="background-overlay"></div>

    <div class="IniTit">
        <div class="justify-content-center">
            <h1 class="shadow-green text-center col-xl-5 col-11 mx-auto py-5">
                Justicia Hídrica · México
            </h1>
        </div>
    </div>

    <div class="headerP">
        <div class="container">
            <section id="menuInd" class="menuInd justify-content-center mt-5">
                <div class="container" data-aos="fade-up">
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 col-lg-2 my-2 tarjeta-menu">
                            <a href="<?= base_url('ElaguaSLP') ?>" class="card-link">
                                <div class="icon-box h-100" data-aos="fade-up" data-aos-delay="100">
                                    <div class="icon"><i class="bi bi-droplet-half"></i></div>
                                    <h3 class="tit">Agua y comunidades en San Luis Potosí</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2 my-2 tarjeta-menu">
                            <a href="<?= base_url('Hidropesquisa') ?>" class="card-link">
                                <div class="icon-box h-100" data-aos="fade-up" data-aos-delay="200">
                                    <div class="icon"><i class="fa-solid fa-hand-holding-droplet"></i></div>
                                    <h3 class="tit">Investigadores comunitarios</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2 my-2 tarjeta-menu">
                            <a href="https://agua.conahcyt.mx/trasvases/" class="card-link">
                                <div class="icon-box h-100" data-aos="fade-up" data-aos-delay="300">
                                    <div class="icon"><i class="bi bi-tsunami"></i></div>
                                    <h3 class="tit">Trasvases y justicia hídrica</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</header>


<main id="main" class="align-items-center">

    <section id="noticias" class="noticias">
        <div class="container pb-0">
            <div class="titulo-seccion pb-0">
                <h2>Eventos y noticias de aliados</h2>
            </div>
        </div>

        <?php if (empty($noticias)): ?>
            <div class="container">
                <p class="text-center text-muted">Por ahora no hay eventos vigentes.</p>
            </div>
        <?php else: ?>
            <div class="container">
                <div class="row mt-5">
                    <div class="swiffy-slider slider-item-reveal slider-item-show2 slider-nav-dark slider-nav-outside slider-nav-caretfill slider-nav-animation-slideup slider-nav-animation slider-indicators-square slider-indicators-outside slider-indicators-dark slider-nav-autoplay slider-nav-autopause">
                        <ul class="slider-container pt-4">
                            <?php foreach ($noticias as $nota): ?>
                                <li class="slide-visible">
                                    <div class="card shadow h-100" style="height: 650px;"
                                         data-bs-toggle="modal" data-bs-target="#imageModal"
                                         data-img="<?= e(base_url($nota['Imagen'] ?? '')) ?>" data-aos="zoom-in-up">
                                        <img src="<?= e(base_url($nota['Imagen'] ?? '')) ?>" class="card-img-top img-fluid"
                                             style="object-fit: cover; height: 600px;" loading="lazy"
                                             alt="<?= e($nota['Titulo'] ?? 'Noticia') ?>">
                                        <div class="card-header">
                                            <h5 class="card-title"><?= e($nota['Titulo'] ?? '') ?></h5>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="slider-nav" aria-label="Anterior"></button>
                        <button type="button" class="slider-nav slider-nav-next" aria-label="Siguiente"></button>
                        <div class="slider-indicators">
                            <?php foreach ($noticias as $i => $nota): ?>
                                <button class="<?= $i === array_key_first($noticias) ? 'active' : '' ?>" aria-label="Ir a la noticia"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal de noticias -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="modalImage" src="" class="img-fluid" alt="Imagen ampliada">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact section-bg">
        <div class="container pb-0">
            <div class="titulo-seccion pb-0">
                <h2>Contacto</h2>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-4 mx-auto" data-aos="fade-up-right" data-aos-delay="150">
                    <a href="<?= base_url('equipo') ?>" class="text-reset">
                        <div class="info-box mt-4">
                            <i class="bi bi-people-fill"></i>
                            <h3>Equipo de investigación</h3>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mx-auto" data-aos="fade-up" data-aos-delay="150">
                    <a href="mailto:justicia.hidrica@colsan.edu.mx" class="text-reset">
                        <div class="info-box mt-4">
                            <i class="bi bi-envelope-paper-fill"></i>
                            <h3>Email</h3>
                            <p>justicia.hidrica@colsan.edu.mx</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mx-auto" data-aos="fade-up-left" data-aos-delay="150">
                    <a href="tel:+524448110101,8433" class="text-reset">
                        <div class="info-box mt-4">
                            <i class="bi bi-telephone-fill"></i>
                            <h3>Teléfono</h3>
                            <p>+52 444 811 01 01 ext. 8433</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Fotos para el fondo rotativo  -->
<script>
    window.__portada = <?= json_encode(
        array_map(fn($img) => base_url($img['Ruta']), $imagenes ?? []),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ) ?>;
</script>