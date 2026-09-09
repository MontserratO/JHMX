<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Vista para páginas que muestran UN documento PDF. (Convenios, informes y esquemas)
 */

$urlPdf = file_url($archivo);
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1><?= e($encabezado) ?></h1>
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
                    <li class="breadcrumb-item active" aria-current="page"><?= e($encabezado) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="doc-seccion">
        <div class="container">

            <div class="titulo-sec">
                <h2><?= e($documento) ?></h2>
            </div>

            <?php if (!empty($descripcion)): ?>
                <p class="doc-intro"><?= e($descripcion) ?></p>
            <?php endif; ?>

            <div id="libro"></div>

        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        VisorLibro.montar(document.getElementById('libro'), {
            url: <?= json_encode($urlPdf, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
        });
    });
</script>