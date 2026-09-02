<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Vista para páginas que muestran UN documento PDF. (Convenios e informes)
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

            <div class="libro" id="libro">

                <!-- Barra superior: buscador dentro del texto y acciones -->
                <div class="libro-barra">
                    <div class="libro-buscador">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <label class="visually-hidden" for="libroBuscar">Buscar en el documento</label>
                        <input type="search" id="libroBuscar" placeholder="Buscar en el documento…">
                    </div>

                    <div class="libro-acciones">
                        <a href="<?= e($urlPdf) ?>" download class="libro-btn" title="Descargar el PDF">
                            <i class="bi bi-download" aria-hidden="true"></i>
                            <span class="libro-btn-txt">Descargar</span>
                        </a>
                        <a href="<?= e($urlPdf) ?>" target="_blank" rel="noopener"
                           class="libro-btn" title="Abrir en una pestaña nueva">
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                            <span class="libro-btn-txt">Abrir aparte</span>
                        </a>
                        <button type="button" class="libro-btn" id="libroPantalla" title="Pantalla completa">
                            <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <p class="libro-resultados" id="libroResultados" aria-live="polite"></p>

                <!-- El libro -->
                <div class="libro-escena">
                    <button type="button" class="libro-flecha izq" id="libroAnterior" aria-label="Página anterior">
                        <i class="bi bi-chevron-left" aria-hidden="true"></i>
                    </button>

                    <div class="libro-hojas" id="libroHojas"></div>

                    <button type="button" class="libro-flecha der" id="libroSiguiente" aria-label="Página siguiente">
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    </button>

                    <div class="libro-cargando" id="libroCargando">
                        <div class="libro-spinner" aria-hidden="true"></div>
                        <p>Preparando el documento…</p>
                    </div>
                </div>

                <!-- Controles inferiores -->
                <div class="libro-pie">
                    <div class="libro-zoom">
                        <button type="button" class="libro-btn" id="libroMenos" aria-label="Alejar">
                            <i class="bi bi-zoom-out" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="libro-btn" id="libroMas" aria-label="Acercar">
                            <i class="bi bi-zoom-in" aria-hidden="true"></i>
                        </button>
                    </div>

                    <span class="libro-indicador" id="libroIndicador" aria-live="polite"></span>

                    <span class="libro-ayuda">Usa ← → para pasar de página</span>
                </div>

                <!-- Miniaturas -->
                <div class="libro-minis" id="libroMinis" aria-label="Miniaturas de las páginas"></div>
            </div>

        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    window.__documento = {
        url:    <?= json_encode($urlPdf, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
        worker: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js'
    };
</script>