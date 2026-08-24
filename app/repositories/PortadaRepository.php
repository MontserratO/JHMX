<?php

/**
 * Acceso a la tabla `portada`.
 * Sustituye el glob() del disco que hacía el index.php.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class PortadaRepository extends Repository
{
    protected string $table = 'portada';
    protected string $defaultOrder = 'Orden';

    protected array $columns  = ['ID', 'Ruta', 'TextoAlt', 'Activa', 'Orden'];
    protected array $fillable = ['Ruta', 'TextoAlt', 'Activa', 'Orden'];

    public function activas(): array
    // Devuelve las imágenes activas, ordenadas por Orden y ID
    {
        $sql  = "SELECT * FROM `{$this->table}` WHERE `Activa` = 1 ORDER BY `Orden`, `ID`";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
