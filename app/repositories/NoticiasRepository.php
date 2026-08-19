<?php

/**
 * NoticiasRepository.php — Acceso a la tabla `noticias`.
 * Reemplaza a noticias.json.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class NoticiasRepository extends Repository
{
    protected string $table = 'noticias';
    protected string $defaultOrder = 'Desde';

    protected array $columns  = ['ID', 'Titulo', 'Imagen', 'Desde', 'Hasta'];
    protected array $fillable = ['Titulo', 'Imagen', 'Desde', 'Hasta'];

    /**
     * Noticias vigentes hoy. Esto es lo que antes se hacía cargando todo el
     * JSON a memoria y filtrándolo con array_filter en PHP; ahora lo resuelve
     * la base de datos con el índice idx_vigencia.
     */
    public function vigentes(): array
    {
        $sql  = "SELECT * FROM `{$this->table}`
                 WHERE CURDATE() BETWEEN `Desde` AND `Hasta`
                 ORDER BY `Desde` DESC";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
