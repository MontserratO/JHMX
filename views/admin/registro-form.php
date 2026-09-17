<?php
defined('JH_APP') || exit('Acceso no permitido.');

/**
 * Formulario de alta y edición de registros.
 */

function es_largo(string $col): bool
{
    return in_array($col, [
        'Descripcion', 'Resumen', 'Observaciones', 'PalabrasCve',
        'Encabezado', 'Titulo', 'DatosColocacion', 'DatosColoca',
    ], true);
}
?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1><?= $esNuevo ? 'Nuevo registro' : 'Editar registro' ?></h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="panel">
        <div class="container">

            <nav class="panel-ruta" aria-label="Ruta">
                <a href="<?= base_url('admin/') ?>">Panel</a>
                <a href="<?= base_url('admin/registros?t=' . e($clave)) ?>">
                    <?= e($def['titulo']) ?>
                </a>
                <span><?= $esNuevo ? 'Nuevo' : 'Editar' ?></span>
            </nav>

            <?php if ($error !== ''): ?>
                <p class="panel-aviso mal" role="alert">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> <?= e($error) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/registros?t=' . e($clave)) ?>"
                  class="panel-form">
                <?= csrf_field() ?>
                <input type="hidden" name="que" value="guardar">
                <input type="hidden" name="id" value="<?= (int) ($registro['ID'] ?? 0) ?>">

                <div class="panel-form-cab">
                    <h2><?= e($def['titulo']) ?></h2>
                    <?php if (!$esNuevo): ?>
                        <span class="panel-form-id">Registro n.º <?= (int) ($registro['ID'] ?? 0) ?></span>
                    <?php endif; ?>
                </div>

                <div class="panel-campos">
                    <?php foreach ($campos as $col => $etiqueta): ?>
                        <?php
                        $valor      = (string) ($registro[$col] ?? '');
                        $obligatorio = ($col === ($def['campoTitulo'] ?? ''));
                        $largo      = es_largo($col);
                        ?>
                        <div class="panel-campo <?= $largo ? 'ancho' : '' ?>">
                            <label for="c_<?= e($col) ?>">
                                <?= e($etiqueta) ?>
                                <?php if ($obligatorio): ?>
                                    <span class="req" title="Campo obligatorio">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if ($largo): ?>
                                <textarea id="c_<?= e($col) ?>" name="c_<?= e($col) ?>"
                                          rows="<?= $col === 'Resumen' || $col === 'Descripcion' ? 5 : 3 ?>"
                                          <?= $obligatorio ? 'required' : '' ?>><?= e($valor) ?></textarea>
                            <?php else: ?>
                                <input type="text" id="c_<?= e($col) ?>" name="c_<?= e($col) ?>"
                                       value="<?= e($valor) ?>" maxlength="500"
                                       <?= $obligatorio ? 'required' : '' ?>>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="panel-form-pie">
                    <a href="<?= base_url('admin/registros?t=' . e($clave)) ?>" class="btn-b">Cancelar</a>
                    <button type="submit" class="btn-a">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                        <?= $esNuevo ? 'Agregar registro' : 'Guardar cambios' ?>
                    </button>
                </div>
            </form>

        </div>
    </section>
</main>
