<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<!-- ======= Encabezado de sección ======= -->
<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Equipo de investigación</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Equipo</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="investig" class="investig">
        <div class="container mt-2">

            <?php if (empty($grupos)): ?>
                <p class="text-center text-muted py-5">Aún no hay integrantes registrados.</p>
            <?php endif; ?>

            <?php foreach ($grupos as $categoria => $personas): ?>
                <div class="titulo-sec">
                    <h2><?= e($categoria) ?></h2>
                </div>

                <div class="row justify-content-center gx-3 gy-4 mb-5">
                    <?php foreach ($personas as $persona): ?>
                        <?php
                        // Si la persona no tiene foto, se usa la imagen genérica.
                        $foto = !empty($persona['Imagen'])
                            ? base_url($persona['Imagen'])
                            : base_url('img/foto.png');
                        ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <!-- Es un <button> y no un <div>: así funciona con teclado
                                 y los lectores de pantalla lo anuncian como accionable. -->
                            <button type="button"
                                    class="equip"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPersona"
                                    data-nombre="<?= e($persona['Nombre']) ?>"
                                    data-cargo="<?= e($persona['Cargo'] ?? '') ?>"
                                    data-descripcion="<?= e($persona['Descripcion'] ?? '') ?>"
                                    data-foto="<?= e($foto) ?>">
                                <div class="equip-img">
                                    <img src="<?= e($foto) ?>"
                                         alt="Fotografía de <?= e($persona['Nombre']) ?>"
                                         loading="lazy">
                                    <span class="equip-lupa" aria-hidden="true">
                                        <i class="bi bi-plus-lg"></i>
                                    </span>
                                    <div class="equip-info">
                                        <p><?= e($persona['Nombre']) ?></p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </section>
</main>

<!-- ======= Modal único =======
     El código viejo generaba UN MODAL POR PERSONA (29 modales en el HTML,
     con las fotos cargadas dos veces). Aquí hay uno solo que se rellena al
     hacer clic, con los datos que trae la tarjeta en sus atributos data-*. -->
<div class="modal fade" id="modalPersona" tabindex="-1" aria-labelledby="modalPersonaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalPersonaLabel"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                        <img id="modalPersonaFoto" src="" alt="" class="img-fluid rounded">
                    </div>
                    <div class="col-12 col-md-8">
                        <p id="modalPersonaCargo" class="equip-cargo"></p>
                        <p id="modalPersonaDesc" class="just mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-a" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>