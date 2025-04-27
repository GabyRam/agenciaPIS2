<?php
require_once __DIR__ . '/IInventario.php'; // Asegura que la interfaz esté cargada

class InventarioReal implements IInventario {
    private $db; // Conexión PDO

    // El constructor ahora recibe la conexión PDO
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function agregarAuto(string $modelo): void {
        // Usar sentencia preparada para seguridad
        $sql = "INSERT INTO autos (modelo) VALUES (:modelo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt->execute();
        echo "<p>Auto '$modelo' registrado correctamente.</p>"; // Mensaje para web
    }

    public function actualizarAuto(int $id, string $nuevoModelo): void {
        // Verificar si el ID existe podría ser una buena mejora
        $sql = "UPDATE autos SET modelo = :modelo WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':modelo', $nuevoModelo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $rowCount = $stmt->execute(); // execute() devuelve true/false, no rowCount directamente para UPDATE en PDO pgsql
        
        // PDOStatement::rowCount() puede no ser fiable para UPDATE en PostgreSQL
        // Podríamos verificar si el ID existía antes o simplemente asumir que funcionó si no hubo excepción.
        if ($rowCount) { // O simplemente verificar que no hubo excepción
             echo "<p>Auto con ID $id actualizado a '$nuevoModelo'.</p>";
        } else {
             echo "<p>No se pudo actualizar el auto con ID $id (puede que no exista).</p>";
        }
    }

    public function listarAutos(): array {
        $sql = "SELECT id, modelo FROM autos ORDER BY id";
        $stmt = $this->db->query($sql); // query() es seguro aquí porque no hay input del usuario
        return $stmt->fetchAll(); // Devuelve un array asociativo
    }
}
?>