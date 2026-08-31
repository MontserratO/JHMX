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

    public function all(array $params = []): array
    {
        $order = pick($params['order'] ?? '', $this->columns, $this->defaultOrder);
        $dir   = pick_dir($params['dir'] ?? '');

        $sql  = "SELECT * FROM `{$this->table}`";
        $bind = [];

        $filtro   = $params['filtro']   ?? '';
        $busqueda = trim($params['busqueda'] ?? '');

        if ($busqueda !== '') {
            if ($filtro === '' || $filtro === 'General') {
                $conds = [];
                foreach ($this->columns as $i => $col) {
                    $conds[]      = "`$col` LIKE :b$i";
                    $bind[":b$i"] = "%$busqueda%";
                }
                $sql .= ' WHERE ' . implode(' OR ', $conds);
            } else {
                $col = pick($filtro, $this->columns, '');
                if ($col !== '') {
                    $sql        .= " WHERE `$col` LIKE :b";
                    $bind[':b']  = "%$busqueda%";
                }
            }
        }

        $sql .= " ORDER BY `{$order}` {$dir} LIMIT 150";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll();
    }

    public function contar(): int
    {
        $stmt = $this->db()->prepare("SELECT COUNT(*) FROM `{$this->table}`");
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM `{$this->table}` WHERE ID = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

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

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM `{$this->table}` WHERE ID = ?");
        return $stmt->execute([$id]);
    }

    private function onlyFillable(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }
}