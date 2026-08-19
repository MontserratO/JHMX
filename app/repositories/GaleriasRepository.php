<?php

/**
 * GaleriasRepository.php — Acceso a `galerias` y `galeria_archivos`.
 *
 * Reemplaza de un solo golpe a imagenes.json, videos.json y esquemas.json,
 * que tenían la misma forma. Se distinguen por el campo Tipo:
 * 'imagen' | 'video' | 'esquema'.
 */

defined('JH_APP') || exit('Acceso no permitido.');

final class GaleriasRepository extends Repository
{
    protected string $table = 'galerias';
    protected string $defaultOrder = 'Orden';

    protected array $columns  = ['ID', 'Nombre', 'Tipo', 'Orden'];
    protected array $fillable = ['Nombre', 'Tipo', 'Orden'];

    /**
     * Devuelve las galerías de un tipo con todos sus archivos dentro:
     *   ['Agua en San Luis Potosí' => [archivo, archivo...], ...]
     */
    public function porTipo(string $tipo): array
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

    /** Archivos de una galería concreta. */
    public function archivos(int $galeriaId): array
    {
        $sql  = "SELECT * FROM galeria_archivos WHERE galeria_id = ? ORDER BY Orden, ID";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute([$galeriaId]);
        return $stmt->fetchAll();
    }

    /** Busca una galería por nombre y tipo; si no existe, la crea. */
    public function galeriaId(string $nombre, string $tipo): int
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

    /** Agrega un archivo a una galería. $libro solo aplica a esquemas. */
    public function agregarArchivo(int $galeriaId, string $titulo, string $ruta,
                                   ?string $libro = null, int $orden = 0): bool
    {
        $sql  = "INSERT INTO galeria_archivos (galeria_id, Titulo, Ruta, Libro, Orden)
                 VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute([$galeriaId, $titulo, $ruta, $libro, $orden]);
    }

    /** Elimina un archivo de la galería (no borra el archivo del disco). */
    public function eliminarArchivo(int $archivoId): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM galeria_archivos WHERE ID = ?");
        return $stmt->execute([$archivoId]);
    }
}
