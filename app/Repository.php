<?php

/**
 * Clase base para el acceso a datos. Antes CAD
 */

defined('JH_APP') || exit('Acceso no permitido.');

abstract class Repository
{
    protected string $table;
    protected array $columns = [];
    protected array $fillable = [];
    protected string $defaultOrder = 'ID';

    protected function db(): PDO
    {
        return Database::conn();
    }

    /**
     * Devuelve valores distintos que existen en una columna, para llenar los filtros
     * desplegables (facetas).
     */
    public function valoresDe(string $columna): array
    {
        $col = pick($columna, $this->columns, '');
        if ($col === '') {
            return [];
        }

        $sql = "SELECT DISTINCT `$col` AS v
                FROM `{$this->table}`
                WHERE `$col` IS NOT NULL AND TRIM(`$col`) <> ''
                ORDER BY `$col`
                LIMIT 300";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Devuelve la cláusula WHERE y los parámetros de enlace para la búsqueda y los filtros.
     */
    private function filtro(array $params): array
    {
        $condiciones = [];
        $bind        = [];
        $facetas = $params['facetas'] ?? [];
        $i = 0;
        foreach ($facetas as $columna => $valor) {
            $valor = trim((string) $valor);
            if ($valor === '') {
                continue;
            }
            $col = pick((string) $columna, $this->columns, '');
            if ($col === '') {
                continue;
            }
            $condiciones[]     = "`$col` = :fac$i";
            $bind[":fac$i"]    = $valor;
            $i++;
        }

        // --- Búsqueda de texto libre ---
        $busqueda = trim($params['busqueda'] ?? '');
        if ($busqueda !== '') {
            $filtro = $params['filtro'] ?? '';

            if ($filtro === '' || $filtro === 'General') {
                $ors = [];
                foreach ($this->columns as $j => $col) {
                    $ors[]        = "`$col` LIKE :b$j";
                    $bind[":b$j"] = "%$busqueda%";
                }
                $condiciones[] = '(' . implode(' OR ', $ors) . ')';
            } else {
                $col = pick($filtro, $this->columns, '');
                if ($col !== '') {
                    $condiciones[] = "`$col` LIKE :b";
                    $bind[':b']    = "%$busqueda%";
                }
            }
        }

        if ($condiciones === []) {
            return ['', []];
        }

        return [' WHERE ' . implode(' AND ', $condiciones), $bind];
    }

    /**
     * Devuelve todos los registros de la tabla, con filtros y paginación.
     */
    public function all(array $params = [], int $porPagina = 0, int $pagina = 1): array
    {
        $order = pick($params['order'] ?? '', $this->columns, $this->defaultOrder);
        $dir   = pick_dir($params['dir'] ?? '');

        [$where, $bind] = $this->filtro($params);

        $sql = "SELECT * FROM `{$this->table}`{$where} ORDER BY `{$order}` {$dir}";

        if ($porPagina > 0) {
            $porPagina = max(1, min(200, $porPagina));
            $offset    = max(0, ($pagina - 1) * $porPagina);
            $sql .= " LIMIT {$porPagina} OFFSET {$offset}";
        }

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll();
    }

    /**
     * Devuelve cuántos registros hay en la tabla, con filtros aplicados.
     */
    public function contarFiltrado(array $params = []): int
    {
        [$where, $bind] = $this->filtro($params);

        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM `{$this->table}`{$where}");
        $stmt->execute($bind);
        return (int) $stmt->fetchColumn();
    }

    /** Devuelve el número total de registros en la tabla. */
    public function contar(): int
    {
        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM `{$this->table}`");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /** Devuelve un registro por su ID, o null si no existe. */
    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM `{$this->table}` WHERE ID = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Inserta un registro. $data es un arreglo columna => valor. */
    public function create(array $data): bool
    {
        $data = $this->onlyFillable($data);
        if ($data === []) {
            return false;
        }

        $cols         = array_keys($data);
        $colList      = implode(', ', array_map(fn($c) => "`$c`", $cols));
        $placeholders = implode(', ', array_fill(0, count($cols), '?'));

        $sql  = "INSERT INTO `{$this->table}` ($colList) VALUES ($placeholders)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    /** Actualiza el registro con ese ID. */
    public function update(int $id, array $data): bool
    {
        $data = $this->onlyFillable($data);
        if ($data === []) {
            return false;
        }

        $sets = implode(', ', array_map(fn($c) => "`$c` = ?", array_keys($data)));
        $sql  = "UPDATE `{$this->table}` SET $sets WHERE ID = ?";

        $values   = array_values($data);
        $values[] = $id;

        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($values);
    }

    /** Elimina el registro con ese ID. */
    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM `{$this->table}` WHERE ID = ?");
        return $stmt->execute([$id]);
    }

    /** Deja pasar solo las claves declaradas en $fillable. */
    private function onlyFillable(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }
}