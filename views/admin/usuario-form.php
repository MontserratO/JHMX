<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1><?= $esNuevo ? 'Nueva cuenta' : 'Editar cuenta' ?></h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="panel">
        <div class="container">

            <nav class="panel-ruta" aria-label="Ruta">
                <a href="<?= base_url('admin/') ?>">Panel</a>
                <a href="<?= base_url('admin/usuarios') ?>">Cuentas</a>
                <span><?= $esNuevo ? 'Nueva' : 'Editar' ?></span>
            </nav>

            <?php if ($error !== ''): ?>
                <p class="panel-aviso mal" role="alert">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> <?= e($error) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="<?= base_url('admin/usuarios') ?>" class="panel-form">
                <?= csrf_field() ?>
                <input type="hidden" name="que" value="<?= $esNuevo ? 'crear' : 'editar' ?>">
                <?php if (!$esNuevo): ?>
                    <input type="hidden" name="id" value="<?= (int) $cuenta['ID'] ?>">
                <?php endif; ?>

                <div class="panel-form-cab">
                    <h2><?= $esNuevo ? 'Datos de la cuenta' : e($cuenta['Nombre']) ?></h2>
                </div>

                <div class="panel-campos">

                    <div class="panel-campo ancho">
                        <label for="nombre">Nombre completo <span class="req">*</span></label>
                        <input type="text" id="nombre" name="nombre" required maxlength="150"
                               value="<?= e($cuenta['Nombre']) ?>">
                    </div>

                    <div class="panel-campo">
                        <label for="usuario">Usuario <span class="req">*</span></label>
                        <?php if ($esNuevo): ?>
                            <input type="text" id="usuario" name="usuario" required maxlength="60"
                                   value="<?= e($cuenta['Usuario']) ?>" autocomplete="off">
                            <p class="campo-nota">Letras, números, punto, guion y guion bajo.</p>
                        <?php else: ?>
                            <input type="text" id="usuario" value="<?= e($cuenta['Usuario']) ?>" disabled>
                            <p class="campo-nota">
                                El usuario no se cambia: es la referencia que guarda la bitácora.
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="panel-campo">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" maxlength="190"
                               value="<?= e($cuenta['Correo'] ?? '') ?>">
                    </div>

                    <div class="panel-campo ancho">
                        <label for="rol">Rol</label>
                        <select id="rol" name="rol">
                            <option value="editor" <?= $cuenta['Rol'] === 'editor' ? 'selected' : '' ?>>
                                Editor — administra contenido y registros
                            </option>
                            <option value="administrador" <?= $cuenta['Rol'] === 'administrador' ? 'selected' : '' ?>>
                                Administrador — administra contenido, registros, cuentas y ve la bitácora
                            </option>
                        </select>
                    </div>

                    <?php if ($esNuevo): ?>
                        <div class="panel-campo ancho">
                            <p class="panel-aviso ok" style="margin:0">
                                <i class="bi bi-info-circle-fill" aria-hidden="true"></i>
                                El sistema generará una contraseña temporal y la mostrará
                                una sola vez al guardar. La persona deberá cambiarla al entrar.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="panel-form-pie">
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn-b">Cancelar</a>
                    <button type="submit" class="btn-a">
                        <i class="bi bi-check-lg" aria-hidden="true"></i>
                        <?= $esNuevo ? 'Crear cuenta' : 'Guardar cambios' ?>
                    </button>
                </div>
            </form>

        </div>
    </section>
</main>
