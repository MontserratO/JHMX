<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($opciones['descripcion'] ?? 'Justicia Hídrica en México — El Colegio de San Luis') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="https://cdn.jsdelivr.net/gh/MontserratO/imagenesPub@main/img/logoI.png">
    <title><?= e($titulo) ?></title>

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

    <!-- Estilos del sitio -->
    <link href="<?= base_url('assets/css/estilos.css') ?>" rel="stylesheet">

    <?php // CSS adicional que pida la página (ej. swiffy-slider en la home)
    foreach ($opciones['css'] ?? [] as $hoja): ?>
        <link href="<?= e($hoja) ?>" rel="stylesheet">
    <?php endforeach; ?>
</head>

<body id="<?= e($opciones['body_id'] ?? 'Pagina') ?>">

    <?php
    // Barras solicitadas por la página. Por defecto, las dos institucionales.
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

    <?php // JS adicional que pida la página
    foreach ($opciones['js'] ?? [] as $script): ?>
        <script src="<?= e($script) ?>"></script>
    <?php endforeach; ?>

    <script>
        AOS.init({ once: true, disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches });
    </script>
</body>

</html>