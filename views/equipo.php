<?php defined('JH_APP') || exit('Acceso no permitido.');
/**
* Página del equipo de investigación de El Agua en San Luis Potosí
*/
 ?>
 
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

    <!-- Listado del equipo -->
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
                        $foto = !empty($persona['Imagen'])
                            ? base_url($persona['Imagen'])
                            : base_url('img/foto.png');
                        ?>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
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

<!-- ======= Modal  ======= -->
<div class="modal fade" id="modalPersona" tabindex="-1" aria-labelledby="modalPersonaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content persona-modal">

            <button type="button" class="persona-cerrar" data-bs-dismiss="modal" aria-label="Cerrar">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="persona-grid">
                <!-- Retrato -->
                <div class="persona-media">
                    <img id="modalPersonaFoto" src="" alt="">
                </div>

                <!-- Datos -->
                <div class="persona-datos">
                    <h2 class="persona-nombre" id="modalPersonaLabel"></h2>
                    <p class="persona-cargo" id="modalPersonaCargo"></p>
                    <p class="persona-desc" id="modalPersonaDesc"></p>
                </div>
            </div>

        </div>
    </div>
</div>