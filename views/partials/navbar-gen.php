/*
    * Layout de Navbar del Sistema (Visible en paginas secundarias)
*/

<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>
<nav id="nav-sistem" class="nav-sistem navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand me-4" href="<?= base_url() ?>">
            <img src="<?= base_url('img/JusticiaHMX.png') ?>" alt="Justicia Hídrica México">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGen"
            aria-controls="navbarGen" aria-expanded="false" aria-label="Abrir menú del sitio">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarGen">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ElaguaSLP') ?>">Agua en SLP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Hidropesquisa') ?>">Hidropesquisa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://agua.conahcyt.mx/trasvases/">Trasvases</a>
                </li>
            </ul>
        </div>
    </div>
</nav>