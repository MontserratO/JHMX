<?php

/**
 * Acceso a las tablas `equipo`, `equipo_categorias`
 * y pibote `equipo_categoria`. Reemplaza a equipo.json.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class EquipoRepository extends Repository
{
    protected string $table = 'equipo';
    protected string $defaultOrder = 'Nombre';

    protected array $columns  = ['ID', 'Nombre', 'Cargo', 'Descripcion', 'Orden'];
    protected array $fillable = ['Nombre', 'Cargo', 'Descripcion', 'Imagen', 'Orden'];

    public function porCategorias(): array
    //Devuelve el equipo agrupado por categoría
    {
        $sql = "SELECT c.Nombre AS categoria, e.*
                FROM equipo_categorias c
                JOIN equipo_categoria ec ON ec.categoria_id = c.ID
                JOIN equipo e           ON e.ID = ec.equipo_id
                ORDER BY c.Orden, c.Nombre, ec.Orden, e.Nombre";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute();

        $agrupado = [];
        foreach ($stmt->fetchAll() as $fila) {
            $categoria = $fila['categoria'];
            unset($fila['categoria']);
            $agrupado[$categoria][] = $fila;
        }
        return $agrupado;
    }

    public function categorias(): array
    //Devuelve las categorías. Listado
    {
        $stmt = $this->db()->prepare("SELECT * FROM equipo_categorias ORDER BY Orden, Nombre");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function categoriaId(string $nombre): int
    //Busca una categoría por nombre; si no existe, la crea. Devuelve su ID.
    {
        $stmt = $this->db()->prepare("SELECT ID FROM equipo_categorias WHERE Nombre = ?");
        $stmt->execute([$nombre]);
        $id = $stmt->fetchColumn();

        if ($id !== false) {
            return (int) $id;
        }

        $stmt = $this->db()->prepare("INSERT INTO equipo_categorias (Nombre) VALUES (?)");
        $stmt->execute([$nombre]);
        return (int) $this->db()->lastInsertId();
    }

    public function asignarCategoria(int $equipoId, int $categoriaId, int $orden = 0): bool
    // Inserta un registro en la tabla pivote. Si ya existía, no hace nada.
    {
        $sql  = "INSERT IGNORE INTO equipo_categoria (equipo_id, categoria_id, Orden)
                 VALUES (?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$equipoId, $categoriaId, $orden]);
    }

    public function quitarCategoria(int $equipoId, int $categoriaId): bool
    // Borra un registro de la tabla pivote. Si no existía, no hace nada.
    {
        $sql  = "DELETE FROM equipo_categoria WHERE equipo_id = ? AND categoria_id = ?";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$equipoId, $categoriaId]);
    }
}
