<?php

/**
 * Acceso a la tabla `noticias`. Reemplaza a noticias.json.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class NoticiasRepository extends Repository
{
    protected string $table = 'noticias';
    protected string $defaultOrder = 'Desde';

    protected array $columns  = ['ID', 'Titulo', 'Imagen', 'Desde', 'Hasta'];
    protected array $fillable = ['Titulo', 'Imagen', 'Desde', 'Hasta'];

    public function vigentes(): array
    // Devuelve las noticias vigentes hoy, ordenadas por fecha de inicio
    {
        $sql  = "SELECT * FROM `{$this->table}`
                 WHERE CURDATE() BETWEEN `Desde` AND `Hasta`
                 ORDER BY `Desde` DESC";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
