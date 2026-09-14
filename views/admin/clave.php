<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Cambiar contraseña</h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="acceso">
        <div class="container">
            <div class="acceso-caja">

                <?php if ($listo): ?>
                    <div class="acceso-icono acceso-ok" aria-hidden="true">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h2>Contraseña actualizada</h2>
                    <a href="<?= base_url('admin/') ?>" class="btn-a acceso-btn">Regresar al panel</a>

                <?php else: ?>
                    <div class="acceso-icono" aria-hidden="true">
                        <i class="bi bi-key"></i>
                    </div>
                    <h2>Cambiar contraseña</h2>

                    <?php if ($obligado): ?>
                        <p class="acceso-aviso">
                            <i class="bi bi-info-circle" aria-hidden="true"></i>
                            Primer acceso. Cambia la contraseña que te asignaron
                            antes de continuar.
                        </p>
                    <?php endif; ?>

                    <?php if ($error !== ''): ?>
                        <p class="acceso-error" role="alert">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <?= e($error) ?>
                        </p>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('admin/clave') ?>">
                        <?= csrf_field() ?>

                        <label for="actual">Contraseña actual</label>
                        <input type="password" id="actual" name="actual" required
                               autocomplete="current-password">

                        <label for="nueva">Nueva contraseña</label>
                        <input type="password" id="nueva" name="nueva" required
                               autocomplete="new-password">
                        <p class="acceso-regla">
                            Al menos 10 caracteres, con letras y números.
                        </p>

                        <label for="repetir">Repite la nueva contraseña</label>
                        <input type="password" id="repetir" name="repetir" required
                               autocomplete="new-password">

                        <button type="submit" class="btn-a acceso-btn">Guardar</button>
                    </form>

                    <?php if (!$obligado): ?>
                        <p class="acceso-pie">
                            <a href="<?= base_url('admin/') ?>">Volver al panel</a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>
