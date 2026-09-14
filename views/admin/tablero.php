<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>

<header id="headerSec">
    <div class="headerSec">
        <div class="container titulo rounded shadow">
            <h1>Panel de administración</h1>
        </div>
    </div>
</header>

<main id="main">
    <section class="panel">
        <div class="container">

            <!-- Barra de sesión -->
            <div class="panel-barra">
                <div class="panel-quien">
                    <i class="bi bi-person-circle" aria-hidden="true"></i>
                    <div>
                        <strong><?= e($usuario['nombre']) ?></strong>
                        <span class="panel-rol"><?= e($usuario['rol']) ?></span>
                    </div>
                </div>
                <div class="panel-acciones">
                    <a href="<?= base_url('admin/clave') ?>" class="btn-b">
                        <i class="bi bi-key" aria-hidden="true"></i> Cambiar contraseña
                    </a>
                    <a href="<?= base_url('admin/logout') ?>" class="btn-b">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Salir
                    </a>
                </div>
            </div>

            <!-- Base de datos -->
            <div class="titulo-sec"><h2>Base de datos</h2></div>
            <div class="row g-3">
                <?php foreach ($resumen as $r): ?>
                    <div class="col-md-4 d-flex">
                        <a href="<?= base_url('admin/registros?t=' . $r['clave']) ?>" class="panel-card">
                            <div class="panel-card-icono">
                                <i class="bi <?= e($r['icono']) ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?= e($r['titulo']) ?></h3>
                            <p class="panel-card-total">
                                <?= number_format($r['total']) ?>
                                <?= $r['total'] === 1 ? 'registro' : 'registros' ?>
                            </p>
                            <span class="panel-card-accion">
                                Administrar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Contenido del sitio -->
            <div class="titulo-sec"><h2>Contenido del sitio</h2></div>
            <div class="row g-3">
                <?php
                $secciones = [
                    ['contenido?s=portada',  'bi-images',      'Imágenes de portada',  'Fotografías del inicio'],
                    ['contenido?s=noticias', 'bi-megaphone',   'Noticias y eventos',   'Avisos con vigencia'],
                    ['contenido?s=equipo',   'bi-people',      'Equipo',               'Integrantes y categorías'],
                    ['contenido?s=tesis',    'bi-mortarboard', 'Tesis con documento',  'Tesis descargables'],
                    ['contenido?s=planes',   'bi-journals',    'Planes y programas',   'Documentos de planeación'],
                    ['contenido?s=galerias', 'bi-collection',  'Recursos visuales',    'Imágenes, videos y esquemas'],
                    ['contenido?s=presas',   'bi-water',       'Presas',               'Fichas técnicas del SIG'],
                ];
                foreach ($secciones as [$ruta, $icono, $titulo, $desc]): ?>
                    <div class="col-md-6 col-lg-4 d-flex">
                        <a href="<?= base_url('admin/' . $ruta) ?>" class="panel-card">
                            <div class="panel-card-icono">
                                <i class="bi <?= e($icono) ?>" aria-hidden="true"></i>
                            </div>
                            <h3><?= e($titulo) ?></h3>
                            <p class="panel-card-desc"><?= e($desc) ?></p>
                            <span class="panel-card-accion">
                                Administrar <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($movimientos)): ?>
                <!-- Bitácora: solo para administradores -->
                <div class="titulo-sec"><h2>Últimos movimientos</h2></div>
                <div class="panel-bitacora">
                    <table>
                        <thead>
                            <tr>
                                <th>Cuándo</th>
                                <th>Quién</th>
                                <th>Qué hizo</th>
                                <th>Dónde</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movimientos as $m): ?>
                                <tr>
                                    <td data-label="Cuándo"><?= e(date('d/m/Y H:i', strtotime($m['Momento']))) ?></td>
                                    <td data-label="Quién"><?= e($m['UsuarioNom']) ?></td>
                                    <td data-label="Qué hizo"><?= e($m['Accion']) ?></td>
                                    <td data-label="Dónde"><?= e($m['Entidad'] ?? '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="panel-bitacora-pie">
                        <a href="<?= base_url('admin/usuarios') ?>">Administrar cuentas</a>
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>
