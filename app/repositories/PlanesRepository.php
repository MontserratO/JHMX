<?php

/**
 * Acceso a `planes` y `plan_documentos`. Reemplaza a ElaguaSLP/planes.json.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class PlanesRepository extends Repository
{
    protected string $table = 'planes';
    protected string $defaultOrder = 'Categoria';

    protected array $columns  = ['ID', 'Categoria', 'Nombre', 'Descripcion', 'Anio', 'Orden'];
    protected array $fillable = ['Categoria', 'Nombre', 'Descripcion', 'Anio', 'Imagen', 'Orden'];

    public function agrupados(): array
    // Devuelve los planes agrupados por categoría, cada uno con sus documentos
    {
        $stmt = $this->db()->prepare("SELECT * FROM planes ORDER BY Orden, Categoria, ID");
        $stmt->execute();
        $planes = $stmt->fetchAll();

        if ($planes === []) {
            return [];
        }

        // Traemos todos los documentos de una sola vez y los repartimos,
        // en lugar de hacer una consulta por plan.
        $stmt = $this->db()->prepare("SELECT * FROM plan_documentos ORDER BY Orden, ID");
        $stmt->execute();

        $docsPorPlan = [];
        foreach ($stmt->fetchAll() as $doc) {
            $docsPorPlan[$doc['plan_id']][] = $doc;
        }

        $agrupado = [];
        foreach ($planes as $plan) {
            $plan['documentos'] = $docsPorPlan[$plan['ID']] ?? [];
            $agrupado[$plan['Categoria']][] = $plan;
        }
        return $agrupado;
    }

    public function documentos(int $planId): array
    // Devuelve los documentos de un plan concreto, ordenados por Orden y ID
    {
        $stmt = $this->db()->prepare("SELECT * FROM plan_documentos WHERE plan_id = ? ORDER BY Orden, ID");
        $stmt->execute([$planId]);
        return $stmt->fetchAll();
    }

    public function agregarDocumento(int $planId, string $nombre, string $ruta, int $orden = 0): bool
    // Inserta un registro en un plan
    {
        $sql  = "INSERT INTO plan_documentos (plan_id, Nombre, Ruta, Orden) VALUES (?, ?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$planId, $nombre, $ruta, $orden]);
    }

    public function eliminarDocumento(int $documentoId): bool
    // Borra un registro de la tabla plan_documentos. No borra el archivo del disco.
    {
        $stmt = $this->db()->prepare("DELETE FROM plan_documentos WHERE ID = ?");
        return $stmt->execute([$documentoId]);
    }

    public function categorias(): array
    // Devuelve las categorías de planes existentes
    {
        $stmt = $this->db()->prepare("SELECT DISTINCT Categoria FROM planes ORDER BY Categoria");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
