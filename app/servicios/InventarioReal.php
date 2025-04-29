<?php
namespace app\servicios; 
use PDO; // Importar PDO global
use PDOException; // Importar PDOException global
require_once __DIR__ . '/../vista/IInventario.php'; // Asegura que la interfaz esté cargada

class InventarioReal implements \app\vista\IInventario {
    private $db; // Conexión PDO

    // El constructor ahora recibe la conexión PDO
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function agregarAuto(string $modelo): void {
        // Usar sentencia preparada para seguridad
        $sql = "INSERT INTO auto (modelo) VALUES (:modelo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt->execute();
        echo "<p>Auto '$modelo' registrado correctamente.</p>"; // Mensaje para web
    }

    public function actualizarAuto(int $id, string $nuevoModelo): void {
        // Verificar si el ID existe podría ser una buena mejora
        $sql = "UPDATE auto SET modelo = :modelo WHERE id_auto = :id_auto";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modelo', $nuevoModelo, PDO::PARAM_STR);
        $stmt->bindParam(':id_auto', $id, PDO::PARAM_INT);
        $rowCount = $stmt->execute(); 
        

        if ($rowCount) { // O simplemente verificar que no hubo excepción
             echo "<p>Auto con ID $id actualizado a '$nuevoModelo'.</p>";
        } else {
             echo "<p>No se pudo actualizar el auto con ID $id (puede que no exista).</p>";
        }
    }

    public function listarAutos(): array {
        $sql = "SELECT id_auto, modelo FROM auto ORDER BY id_auto";
        $stmt = $this->db->query($sql); // query() es seguro aquí porque no hay input del usuario
        return $stmt->fetchAll(); // Devuelve un array asociativo
    }
}
?>