<?php defined('JH_APP') || exit('Acceso no permitido.');
/**
* Layout de Navbar del Subsistema El Agua en SLP (Visible solo en páginas de Agenda en SLP)
*/
 ?>

<nav id="nav-sistem" class="nav-sistem navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand me-3" href="<?= base_url() ?>">
            <img src="<?= base_url('img/JusticiaHMX.png') ?>" alt="Justicia Hídrica México">
        </a>
        <a class="navbar-brand" href="<?= base_url('ElaguaSLP') ?>">
            <img src="<?= base_url('img/logoEASLP.png') ?>" alt="El Agua en SLP">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSist"
            aria-controls="navbarSist" aria-expanded="false" aria-label="Abrir menú del subsistema">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSist">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navSistBase" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Base de Datos</a>
                    <ul class="dropdown-menu" aria-labelledby="navSistBase">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('ElaguaSLP/base') ?>">
                                Inicio
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('ElaguaSLP/base/tesis') ?>">
                                Tesis de Grado y Posgrado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('ElaguaSLP/base/prensa') ?>">
                                Noticias Periodísticas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('ElaguaSLP/base/leyes') ?>">
                                Leyes y Reglamentos
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP/informes') ?>"
                       title="Informes, Ponencias y Artículos">Informes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP/tesis') ?>">Tesis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP/planes') ?>"
                       title="Planes y Programas">Planes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP/convenios') ?>">Convenios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP/imagenes') ?>">Recursos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navSistSig" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">SIG</a>
                    <ul class="dropdown-menu" aria-labelledby="navSistSig">
                        <li><a class="dropdown-item" href="<?= base_url('ElaguaSLP/SIG') ?>">Inicio</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('ElaguaSLP/SIG/administracionAgu') ?>">Administración de Agua</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('ElaguaSLP/SIG/presas') ?>">Presas</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('ElaguaSLP/SIG/acuiferosSLP') ?>">Crecimiento de la ciudad</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('ElaguaSLP/SIG/mapas') ?>">Mapas</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>