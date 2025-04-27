<?php
require_once __DIR__ . '/IInventario.php'; // Asegura que la interfaz esté cargada

class ProxyInventario implements IInventario {
    private $inventarioReal;
    private $esAdmin;

    // El constructor sigue recibiendo una instancia que implementa IInventario
    public function __construct(IInventario $real, bool $esAdmin) {
        $this->inventarioReal = $real;
        $this->esAdmin = $esAdmin;
    }

    // Verifica permisos antes de llamar al objeto real
    public function agregarAuto(string $modelo): void {
        if (!$this->esAdmin) {
            echo "<p>Acceso denegado: Solo los administradores pueden agregar autos.</p>";
            return; // O lanzar una excepción
        }
        $this->inventarioReal->agregarAuto($modelo);
    }

    // Verifica permisos
    public function actualizarAuto(int $id, string $nuevoModelo): void {
        if (!$this->esAdmin) {
            echo "<p>Acceso denegado: Solo los administradores pueden actualizar autos.</p>";
            return; // O lanzar una excepción
        }
        $this->inventarioReal->actualizarAuto($id, $nuevoModelo);
    }

    // Listar es permitido para todos
    public function listarAutos(): array {
        return $this->inventarioReal->listarAutos();
    }
}
?>