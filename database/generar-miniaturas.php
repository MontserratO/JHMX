<?php

/**
 * Crea versiones reducidas de las fotos.
 */

header('Content-Type: text/plain; charset=utf-8');

const ANCHO_MAX  = 600;   // lado mayor de la miniatura, en píxeles
const CALIDAD    = 78;    // calidad JPEG
const RAIZ_FOTOS = __DIR__ . '/../img/Fotos';

if (!extension_loaded('gd')) {
    exit("ERROR: la extensión GD de PHP no está activa.\n"
       . "Sin ella no se pueden generar miniaturas.\n"
       . "En XAMPP se activa quitando el ';' de 'extension=gd' en php.ini.\n");
}

echo "==========================================\n";
echo " GENERADOR DE MINIATURAS\n";
echo "==========================================\n\n";

/** Crea una miniatura de $origen en $destino. Devuelve true si la creó. */
function miniaturizar(string $origen, string $destino): bool
{
    $info = @getimagesize($origen);
    if ($info === false) {
        return false;
    }

    [$ancho, $alto, $tipo] = $info;

    // Si ya es pequeña, se copia tal cual.
    if ($ancho <= ANCHO_MAX && $alto <= ANCHO_MAX) {
        return copy($origen, $destino);
    }

    switch ($tipo) {
        case IMAGETYPE_JPEG: $img = @imagecreatefromjpeg($origen); break;
        case IMAGETYPE_PNG:  $img = @imagecreatefrompng($origen);  break;
        case IMAGETYPE_GIF:  $img = @imagecreatefromgif($origen);  break;
        default:             return false;
    }
    if (!$img) {
        return false;
    }

    // Escala manteniendo la proporción
    $escala      = ANCHO_MAX / max($ancho, $alto);
    $nuevoAncho  = (int) round($ancho * $escala);
    $nuevoAlto   = (int) round($alto * $escala);

    $mini = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Conserva la transparencia en PNG y GIF
    if ($tipo === IMAGETYPE_PNG || $tipo === IMAGETYPE_GIF) {
        imagealphablending($mini, false);
        imagesavealpha($mini, true);
    }

    imagecopyresampled($mini, $img, 0, 0, 0, 0,
                       $nuevoAncho, $nuevoAlto, $ancho, $alto);

    // Se guardan siempre como JPEG salvo PNG con transparencia
    $ok = ($tipo === IMAGETYPE_PNG)
        ? imagepng($mini, $destino, 8)
        : imagejpeg($mini, $destino, CALIDAD);

    imagedestroy($img);
    imagedestroy($mini);

    return $ok;
}

if (!is_dir(RAIZ_FOTOS)) {
    exit("No se encontró la carpeta img/Fotos/\n");
}

$totalCreadas = 0;
$totalSaltadas = 0;
$totalFallidas = 0;
$bytesAntes = 0;
$bytesDespues = 0;

foreach (scandir(RAIZ_FOTOS) as $galeria) {
    if ($galeria === '.' || $galeria === '..') {
        continue;
    }

    $dirGaleria = RAIZ_FOTOS . '/' . $galeria;
    if (!is_dir($dirGaleria)) {
        continue;
    }

    $dirThumbs = $dirGaleria . '/thumbs';
    if (!is_dir($dirThumbs) && !mkdir($dirThumbs, 0755, true)) {
        echo "  ! No se pudo crear $dirThumbs\n";
        continue;
    }

    echo "[$galeria]\n";
    $creadas = 0;

    foreach (scandir($dirGaleria) as $archivo) {
        $ruta = $dirGaleria . '/' . $archivo;
        if (!is_file($ruta)) {
            continue;
        }

        $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
            continue;
        }

        $destino = $dirThumbs . '/' . $archivo;

        if (is_file($destino) && filemtime($destino) >= filemtime($ruta)) {
            $totalSaltadas++;
            continue;
        }

        $pesoAntes = filesize($ruta);

        if (miniaturizar($ruta, $destino)) {
            $creadas++;
            $totalCreadas++;
            $bytesAntes   += $pesoAntes;
            $bytesDespues += filesize($destino);
        } else {
            echo "  ! No se pudo procesar: $archivo\n";
            $totalFallidas++;
        }
    }

    echo "    $creadas miniaturas\n";
}

echo "\n==========================================\n";
echo " RESUMEN\n";
echo "==========================================\n";
echo "  Creadas:  $totalCreadas\n";
echo "  Ya existían: $totalSaltadas\n";
echo "  Fallidas: $totalFallidas\n";

if ($bytesAntes > 0) {
    $mbAntes   = round($bytesAntes / 1048576, 1);
    $mbDespues = round($bytesDespues / 1048576, 1);
    $ahorro    = round(100 - ($bytesDespues / $bytesAntes * 100));
    echo "\n  Peso original:  {$mbAntes} MB\n";
    echo "  Peso miniaturas: {$mbDespues} MB\n";
    echo "  Ahorro: {$ahorro}%\n";
}

echo "\nListo. Recuerda subir las carpetas thumbs/ al servidor\n";
echo "y BORRAR este archivo del proyecto.\n";
