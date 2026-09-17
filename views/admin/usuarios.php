<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Cuentas de acceso</h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="panel">
        <div class="container">

            <nav class="panel-ruta" aria-label="Ruta">
                <a href="<?= base_url('admin/') ?>">
                    Panel
                </a>
                <span>Cuentas de acceso</span>
            </nav>

            <?php if ($mensaje !== ''): ?>
                <p class="panel-aviso ok" role="status">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i> <?= e($mensaje) ?>
                </p>
            <?php endif; ?>
            <?php if ($error !== ''): ?>
                <p class="panel-aviso mal" role="alert">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i> <?= e($error) ?>
                </p>
            <?php endif; ?>

            <?php if ($claveNueva !== ''): ?>
                <div class="clave-temporal">
                    <h3><i class="bi bi-key-fill" aria-hidden="true"></i> Contraseña temporal</h3>
                    <p class="clave-valor"><code><?= e($claveNueva) ?></code></p>
                    <p class="clave-nota">
                        Resguarda y entrégasela al nuevo usuario por un medio seguro.
                        <strong>No volverá a mostrarse</strong>: el sistema solo guarda
                        su versión cifrada. Se le pedirá cambiarla al entrar.
                    </p>
                </div>
            <?php endif; ?>

            <div class="panel-herramientas">
                <p class="panel-conteo" style="margin:0">
                    <strong><?= count($cuentas) ?></strong>
                    <?= count($cuentas) === 1 ? 'cuenta registrada' : 'cuentas registradas' ?>
                </p>
                <a href="<?= base_url('admin/usuarios?accion=nuevo') ?>" class="btn-a panel-nuevo">
                    <i class="bi bi-person-plus" aria-hidden="true"></i> Nueva cuenta
                </a>
            </div>

            <div class="panel-tabla-cont">
                <table class="panel-tabla">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Último acceso</th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cuentas as $c): ?>
                            <?php $soyYo = ((int) $c['ID'] === (int) $yo['id']); ?>
                            <tr class="<?= $c['Activo'] ? '' : 'cuenta-inactiva' ?>">
                                <td data-label="Nombre">
                                    <?= e($c['Nombre']) ?>
                                    <?php if ($soyYo): ?>
                                        <span class="etq-yo">tú</span>
                                    <?php endif; ?>
                                    <?php if ($c['CambiarClave']): ?>
                                        <span class="etq-pendiente" title="Aún no ha cambiado su contraseña inicial">
                                            clave sin cambiar
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Usuario"><code><?= e($c['Usuario']) ?></code></td>
                                <td data-label="Rol">
                                    <span class="etq-rol <?= e($c['Rol']) ?>"><?= e($c['Rol']) ?></span>
                                </td>
                                <td data-label="Estado">
                                    <?= $c['Activo'] ? 'Activa' : 'Desactivada' ?>
                                </td>
                                <td data-label="Último acceso">
                                    <?= $c['UltimoAcceso']
                                        ? e(date('d/m/Y H:i', strtotime($c['UltimoAcceso'])))
                                        : '—' ?>
                                </td>
                                <td class="col-acciones" data-label="Acciones">
                                    <a href="<?= base_url('admin/usuarios?accion=editar&id=' . (int) $c['ID']) ?>"
                                       class="btn-b btn-chico">
                                        <i class="bi bi-pencil" aria-hidden="true"></i> Editar
                                    </a>

                                    <form method="post" action="<?= base_url('admin/usuarios') ?>"
                                          class="form-eliminar" style="display:inline"
                                          data-nombre="restablecer la contraseña de <?= e($c['Nombre']) ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="que" value="restablecer">
                                        <input type="hidden" name="id" value="<?= (int) $c['ID'] ?>">
                                        <button type="submit" class="btn-b btn-chico">
                                            <i class="bi bi-key" aria-hidden="true"></i> Restablecer
                                        </button>
                                    </form>

                                    <?php if (!$soyYo): ?>
                                        <form method="post" action="<?= base_url('admin/usuarios') ?>"
                                              class="form-eliminar" style="display:inline"
                                              data-nombre="<?= $c['Activo'] ? 'desactivar' : 'reactivar' ?> la cuenta de <?= e($c['Nombre']) ?>">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="que" value="estado">
                                            <input type="hidden" name="id" value="<?= (int) $c['ID'] ?>">
                                            <button type="submit"
                                                    class="btn-chico <?= $c['Activo'] ? 'btn-peligro' : 'btn-b' ?>">
                                                <i class="bi bi-<?= $c['Activo'] ? 'slash-circle' : 'check-circle' ?>"
                                                   aria-hidden="true"></i>
                                                <?= $c['Activo'] ? 'Desactivar' : 'Reactivar' ?>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</main>
