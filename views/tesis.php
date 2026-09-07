<?php
defined('JH_APP') || exit('Acceso no permitido.');
/**
 * Pagina de tesis con documento descargable.
 */

function nivel_corto(?string $nivel): array
{
    $n = mb_strtolower((string) $nivel);

    if (str_contains($n, 'doctor'))    return ['Doctorado', 'nivel-doctorado'];
    if (str_contains($n, 'maestr'))    return ['Maestría',  'nivel-maestria'];
    if (str_contains($n, 'licenciad') || str_contains($n, 'licenciatura')) {
        return ['Licenciatura', 'nivel-licenciatura'];
    }
    return ['Tesis', 'nivel-otro'];
}
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Tesis</h1>
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
                    <li class="breadcrumb-item active" aria-current="page">Tesis</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="tesis-seccion">
        <div class="container pt-4">

            <?php if (empty($tesis)): ?>
                <p class="text-center text-muted py-5">Aún no hay tesis publicadas.</p>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($tesis as $i => $t): ?>
                        <?php
                        [$etiqueta, $claseNivel] = nivel_corto($t['Nivel'] ?? '');
                        $url = file_url($t['Ruta']);
                        ?>
                        <div class="col-md-6 d-flex">
                            <button type="button" class="tesis-card"
                                    data-bs-toggle="modal" data-bs-target="#modalPdf"
                                    data-pdf="<?= e($url) ?>"
                                    data-titulo="<?= e($t['Titulo']) ?>"
                                    data-aos="fade-up" data-aos-delay="<?= 80 * ($i % 4) ?>">

                                <div class="tesis-cabecera">
                                    <span class="tesis-nivel <?= e($claseNivel) ?>"><?= e($etiqueta) ?></span>
                                    <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                </div>

                                <h3 class="tesis-titulo"><?= e($t['Titulo']) ?></h3>

                                <p class="tesis-autor">
                                    <i class="bi bi-person" aria-hidden="true"></i>
                                    <?= e($t['Autor']) ?>
                                </p>

                                <?php if (!empty($t['Nivel'])): ?>
                                    <p class="tesis-grado"><?= e($t['Nivel']) ?></p>
                                <?php endif; ?>

                                <span class="tesis-accion">
                                    Leer documento <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </span>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php View::partial('modal-pdf'); ?>