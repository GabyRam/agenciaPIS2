<?php
namespace app\servicios\Usuario\Inventario;

use PDO;
use PDOException;
use app\modelo\Inventario\IInventario;

require_once __DIR__ . '/../../../modelo/Inventario/IInventario.php';

class InventarioReal implements IInventario {
    private $db;
    private $modoPDO; // true si es PDO, false si es pg_connect

    public function __construct($db) {
        $this->db = $db;
        $this->modoPDO = ($db instanceof PDO);
    }

    public function agregarAuto(string $modelo): void {
        if ($this->modoPDO) {
            // Usando PDO
            $sql = "INSERT INTO auto (modelo) VALUES (:modelo)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            // Usando pg_connect
            $modeloEscapado = pg_escape_string($this->db, $modelo);
            $sql = "INSERT INTO auto (modelo) VALUES ('$modeloEscapado')";
            pg_query($this->db, $sql);
        }
        echo "<p>Auto '$modelo' registrado correctamente.</p>";
    }

    public function actualizarAuto(int $id, string $nuevoModelo): void {
        if ($this->modoPDO) {
            $sql = "UPDATE auto SET modelo = :modelo WHERE id_auto = :id_auto";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':modelo', $nuevoModelo, PDO::PARAM_STR);
            $stmt->bindParam(':id_auto', $id, PDO::PARAM_INT);
            $rowCount = $stmt->execute();
        } else {
            $modeloEscapado = pg_escape_string($this->db, $nuevoModelo);
            $sql = "UPDATE auto SET modelo = '$modeloEscapado' WHERE id_auto = $id";
            $resultado = pg_query($this->db, $sql);
            $rowCount = pg_affected_rows($resultado) > 0;
        }

        if ($rowCount) {
            echo "<p>Auto con ID $id actualizado a '$nuevoModelo'.</p>";
        } else {
            echo "<p>No se pudo actualizar el auto con ID $id (puede que no exista).</p>";
        }
    }

    public function listarAutos(): array {
        if ($this->modoPDO) {
            $sql = "SELECT id_auto, modelo FROM auto ORDER BY id_auto";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT id_auto, modelo FROM auto ORDER BY id_auto";
            $resultado = pg_query($this->db, $sql);
            $autos = [];
            while ($row = pg_fetch_assoc($resultado)) {
                $autos[] = $row;
            }
            return $autos;
        }
    }
}
?>
