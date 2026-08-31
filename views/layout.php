<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($opciones['descripcion'] ?? 'Justicia Hídrica en México — El Colegio de San Luis') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('img/logoI.png') ?>">
    <title><?= e($titulo) ?></title>

    <?php
    $esquema  = (($_SERVER['HTTPS'] ?? '') === 'on'
                 || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') ? 'https' : 'http';
    $dominio  = $esquema . '://' . ($_SERVER['HTTP_HOST'] ?? 'www.colsan.edu.mx');
    $urlPagina = $dominio . ($_SERVER['REQUEST_URI'] ?? base_url());
    $urlImagen = $dominio . base_url($opciones['og_imagen'] ?? 'img/JusticiaHMX.png');
    ?>

    <!-- Vista previa al compartir el enlace (WhatsApp, Facebook, X...) -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Justicia Hídrica México">
    <meta property="og:locale" content="es_MX">
    <meta property="og:title" content="<?= e($titulo) ?>">
    <meta property="og:description" content="<?= e($opciones['descripcion'] ?? 'Justicia Hídrica en México — El Colegio de San Luis') ?>">
    <meta property="og:url" content="<?= e($urlPagina) ?>">
    <meta property="og:image" content="<?= e($urlImagen) ?>">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Tipografías -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500;600;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Librerías -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <!-- Estilos generales -->
    <link href="<?= base_url('assets/css/base.css') ?>" rel="stylesheet">

    <?php // CSS adicional que pida la página: la hoja de su subsistema 
    foreach ($opciones['css'] ?? [] as $hoja): ?>
        <link href="<?= e($hoja) ?>" rel="stylesheet">
    <?php endforeach; ?>
</head>

<body id="<?= e($opciones['body_id'] ?? 'Pagina') ?>">

    <a href="#main" class="saltar-contenido">Saltar al contenido principal</a>

    <?php
    foreach ($opciones['navbars'] ?? ['navbar-gob', 'navbar-colsan'] as $barra) {
        View::partial($barra);
    }
    ?>

    <?= $contenido ?>

    <?php View::partial('footer'); ?>

    <!-- Scripts base -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="<?= base_url('assets/js/navbars.js') ?>"></script>

    <?php
    foreach ($opciones['js'] ?? [] as $script): ?>
        <script src="<?= e($script) ?>"></script>
    <?php endforeach; ?>

    <script>
        AOS.init({ once: true, disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches });
    </script>
</body>

</html>