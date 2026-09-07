<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Planes y programas agrupados por categoría.
 */
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Planes y Programas</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Planes y Programas</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="planes-seccion">
        <div class="container pt-4">

            <?php if (empty($grupos)): ?>
                <p class="text-center text-muted py-5">Aún no hay planes publicados.</p>
            <?php endif; ?>

            <?php foreach ($grupos as $categoria => $planes): ?>
                <?php foreach ($planes as $plan): ?>
                    <article class="plan-card" data-aos="fade-up">

                        <div class="plan-encabezado">
                            <h2><?= e($plan['Nombre'] ?: $categoria) ?></h2>
                            <?php if (!empty($plan['Anio'])): ?>
                                <span class="plan-anio"><?= e($plan['Anio']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="plan-cuerpo">

                            <div class="plan-contenido my-auto">
                                <?php if (!empty($plan['Descripcion'])): ?>
                                    <p class="plan-desc"><?= e($plan['Descripcion']) ?></p>
                                <?php endif; ?>

                                <?php if (!empty($plan['documentos'])): ?>
                                    <ul class="plan-docs">
                                        <?php foreach ($plan['documentos'] as $doc): ?>
                                            <?php $url = file_url($doc['Ruta']); ?>
                                            <li>
                                                <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                                <span class="plan-doc-nombre"><?= e($doc['Nombre']) ?></span>
                                                <button type="button" class="btn-a plan-doc-ver"
                                                        data-bs-toggle="modal" data-bs-target="#modalPdf"
                                                        data-pdf="<?= e($url) ?>"
                                                        data-titulo="<?= e($doc['Nombre']) ?>">
                                                    Ver
                                                </button>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Sin documentos disponibles.</p>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($plan['Imagen'])): ?>
                                <div class="plan-imagen">
                                    <img src="<?= e(file_url($plan['Imagen'])) ?>"
                                         alt="Portada de <?= e($plan['Nombre'] ?: $categoria) ?>"
                                         loading="lazy">
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endforeach; ?>

        </div>
    </section>
</main>

<?php View::partial('modal-pdf'); ?>