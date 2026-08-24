<?php

/**
 * Acceso a `galerias` y `galeria_archivos`. Reemplaza a imagenes.json, videos.json y esquemas.json,con nuevo campo Tipo: 'imagen' | 'video' | 'esquema'.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class GaleriasRepository extends Repository
{
    protected string $table = 'galerias';
    protected string $defaultOrder = 'Orden';

    protected array $columns  = ['ID', 'Nombre', 'Tipo', 'Orden'];
    protected array $fillable = ['Nombre', 'Tipo', 'Orden'];

    public function porTipo(string $tipo): array
    //Devuelve las galerias de un tipo con todos sus archivos
    {
        $tipo = pick($tipo, ['imagen', 'video', 'esquema'], 'imagen');

        $sql = "SELECT g.Nombre AS galeria, a.*
                FROM galerias g
                JOIN galeria_archivos a ON a.galeria_id = g.ID
                WHERE g.Tipo = ?
                ORDER BY g.Orden, g.Nombre, a.Orden, a.ID";

        $stmt = $this->db()->prepare($sql);
        $stmt->execute([$tipo]);

        $agrupado = [];
        foreach ($stmt->fetchAll() as $fila) {
            $galeria = $fila['galeria'];
            unset($fila['galeria']);
            $agrupado[$galeria][] = $fila;
        }
        return $agrupado;
    }

    public function archivos(int $galeriaId): array
    // Devuelve los archivos de una galería concreta, ordenados por Orden y ID
    {
        $sql  = "SELECT * FROM galeria_archivos WHERE galeria_id = ? ORDER BY Orden, ID";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute([$galeriaId]);
        return $stmt->fetchAll();
    }

    public function galeriaId(string $nombre, string $tipo): int
    //Busca una galería por nombre y tipo; si no existe, la crea. Devuelve su ID.
    {
        $stmt = $this->db()->prepare("SELECT ID FROM galerias WHERE Nombre = ? AND Tipo = ?");
        $stmt->execute([$nombre, $tipo]);
        $id = $stmt->fetchColumn();

        if ($id !== false) {
            return (int) $id;
        }

        $stmt = $this->db()->prepare("INSERT INTO galerias (Nombre, Tipo) VALUES (?, ?)");
        $stmt->execute([$nombre, $tipo]);
        return (int) $this->db()->lastInsertId();
    }

    public function agregarArchivo(int $galeriaId, string $titulo, string $ruta,
                                   ?string $libro = null, int $orden = 0): bool
                                   // Inserta un registro de tipo libro
    {
        $sql  = "INSERT INTO galeria_archivos (galeria_id, Titulo, Ruta, Libro, Orden)
                 VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$galeriaId, $titulo, $ruta, $libro, $orden]);
    }

    public function eliminarArchivo(int $archivoId): bool
    // Borra un registro de la galeria. Si no existía, no hace nada.
    {
        $stmt = $this->db()->prepare("DELETE FROM galeria_archivos WHERE ID = ?");
        return $stmt->execute([$archivoId]);
    }
}
