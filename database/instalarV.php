<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Primera cuenta</h1>
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
                    <h2>Cuenta creada</h2>
                    <a href="<?= base_url('admin/login') ?>" class="btn-a acceso-btn">Entrar</a>

                <?php else: ?>
                    <div class="acceso-icono" aria-hidden="true">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h2>Crear la cuenta de administrador</h2>
                    <p class="acceso-nota">
                        Esta página solo funciona mientras no exista ninguna cuenta.
                    </p>

                    <?php if ($error !== ''): ?>
                        <p class="acceso-error" role="alert">
                            <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                            <?= e($error) ?>
                        </p>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('admin/instalar') ?>">
                        <?= csrf_field() ?>

                        <label for="nombre">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" required maxlength="150">

                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" name="usuario" required maxlength="60"
                               autocomplete="username">

                        <label for="clave">Contraseña</label>
                        <input type="password" id="clave" name="clave" required
                               autocomplete="new-password">
                        <p class="acceso-regla">
                            Al menos 10 caracteres, con letras y números.
                        </p>

                        <button type="submit" class="btn-a acceso-btn">Crear cuenta</button>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>
