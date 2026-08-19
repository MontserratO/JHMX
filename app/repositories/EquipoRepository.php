<?php

/**
 * EquipoRepository.php — Acceso a las tablas `equipo`, `equipo_categorias`
 * y la intermedia `equipo_categoria`. Reemplaza a equipo.json.
 *
 * Recuerda que una persona puede estar en VARIAS categorías (como Elda,
 * que es coordinadora y parte del equipo técnico). Por eso además del CRUD
 * heredado hay métodos para manejar esa relación.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class EquipoRepository extends Repository
{
    protected string $table = 'equipo';
    protected string $defaultOrder = 'Nombre';

    protected array $columns  = ['ID', 'Nombre', 'Cargo', 'Descripcion', 'Orden'];
    protected array $fillable = ['Nombre', 'Cargo', 'Descripcion', 'Imagen', 'Orden'];

    /**
     * Devuelve el equipo agrupado por categoría, listo para pintar la página:
     *   ['Coordinadores' => [persona, persona...], 'Investigadores' => [...]]
     */
    public function porCategorias(): array
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

    /** Todas las categorías existentes (para los menús desplegables del panel). */
    public function categorias(): array
    {
        $stmt = $this->db()->prepare("SELECT * FROM equipo_categorias ORDER BY Orden, Nombre");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Busca una categoría por nombre; si no existe, la crea. Devuelve su ID. */
    public function categoriaId(string $nombre): int
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

    /** Asigna una persona a una categoría (sin duplicar si ya estaba). */
    public function asignarCategoria(int $equipoId, int $categoriaId, int $orden = 0): bool
    {
        $sql  = "INSERT IGNORE INTO equipo_categoria (equipo_id, categoria_id, Orden)
                 VALUES (?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$equipoId, $categoriaId, $orden]);
    }

    /** Quita a una persona de una categoría (la persona sigue existiendo). */
    public function quitarCategoria(int $equipoId, int $categoriaId): bool
    {
        $sql  = "DELETE FROM equipo_categoria WHERE equipo_id = ? AND categoria_id = ?";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$equipoId, $categoriaId]);
    }
}
