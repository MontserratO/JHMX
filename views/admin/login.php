<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Panel de administración</h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="acceso">
        <div class="container">
            <div class="acceso-caja">

                <div class="acceso-icono" aria-hidden="true">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <h2>Acceso restringido</h2>
                <p class="acceso-nota">Ingresa con tu cuenta personal.</p>

                <?php if ($error !== ''): ?>
                    <p class="acceso-error" role="alert">
                        <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                        <?= e($error) ?>
                    </p>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin/login') ?>" autocomplete="on">
                    <?= csrf_field() ?>
                    <input type="hidden" name="volver" value="<?= e($volver) ?>">

                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required autofocus
                           autocomplete="username" maxlength="60">

                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" required
                           autocomplete="current-password">

                    <button type="submit" class="btn-a acceso-btn">Entrar</button>
                </form>

                <p class="acceso-pie">
                    ¿Olvidaste tu contraseña? Pídele a un administrador que te la restablezca.
                </p>
            </div>
        </div>
    </section>
</main>
