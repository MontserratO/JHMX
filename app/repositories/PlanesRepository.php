<?php

/**
 * PlanesRepository.php — Acceso a `planes` y `plan_documentos`.
 * Reemplaza a ElaguaSLP/planes.json.
 *
 * Nota: agregarDocumento() recibe el ID de UN plan concreto. Eso corrige el
 * bug del código viejo, donde subir un PDF lo agregaba a todos los planes de
 * la categoría por usar `foreach ($planes[$cat] as &$plan)`.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class PlanesRepository extends Repository
{
    protected string $table = 'planes';
    protected string $defaultOrder = 'Categoria';

    protected array $columns  = ['ID', 'Categoria', 'Nombre', 'Descripcion', 'Anio', 'Orden'];
    protected array $fillable = ['Categoria', 'Nombre', 'Descripcion', 'Anio', 'Imagen', 'Orden'];

    /**
     * Planes agrupados por categoría, cada uno con sus documentos dentro.
     * Es la forma en que la página los necesita para pintarse.
     */
    public function agrupados(): array
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

    /** Documentos de un plan concreto. */
    public function documentos(int $planId): array
    {
        $stmt = $this->db()->prepare("SELECT * FROM plan_documentos WHERE plan_id = ? ORDER BY Orden, ID");
        $stmt->execute([$planId]);
        return $stmt->fetchAll();
    }

    /** Agrega un PDF a UN plan específico. */
    public function agregarDocumento(int $planId, string $nombre, string $ruta, int $orden = 0): bool
    {
        $sql  = "INSERT INTO plan_documentos (plan_id, Nombre, Ruta, Orden) VALUES (?, ?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$planId, $nombre, $ruta, $orden]);
    }

    /** Elimina un documento (no borra el PDF del disco). */
    public function eliminarDocumento(int $documentoId): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM plan_documentos WHERE ID = ?");
        return $stmt->execute([$documentoId]);
    }

    /** Lista de categorías existentes, para los menús del panel. */
    public function categorias(): array
    {
        $stmt = $this->db()->prepare("SELECT DISTINCT Categoria FROM planes ORDER BY Categoria");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
