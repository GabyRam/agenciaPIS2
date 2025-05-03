<?php
namespace app\servicios\Usuario\Inventario;

use app\modelo\Inventario\IInventario;

require_once __DIR__ . '/../../../modelo/Inventario/IInventario.php';

class ProxyInventario implements IInventario {
    private $inventarioReal;
    private $esAdmin;

    public function __construct(IInventario $real, bool $esAdmin) {
        $this->inventarioReal = $real;
        $this->esAdmin = $esAdmin;
    }

    public function agregarAuto(string $modelo): void {
        if (!$this->esAdmin) {
            echo "<p>Acceso denegado: Solo los administradores pueden agregar autos.</p>";
            return;
        }
        $this->inventarioReal->agregarAuto($modelo);
    }

    public function actualizarAuto(int $id, string $nuevoModelo): void {
        if (!$this->esAdmin) {
            echo "<p>Acceso denegado: Solo los administradores pueden actualizar autos.</p>";
            return;
        }
        $this->inventarioReal->actualizarAuto($id, $nuevoModelo);
    }

    public function listarAutos(): array {
        return $this->inventarioReal->listarAutos();
    }
}
?>