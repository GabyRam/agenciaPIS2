<?php
class ProxyInventario implements IInventario {
    private $inventarioReal;
    private $esAdmin;

    public function __construct(IInventario $real, bool $esAdmin) {
        $this->inventarioReal = $real;
        $this->esAdmin = $esAdmin;
    }

    public function agregarAuto(string $auto): void {
        // Solo el admin puede llegar aquí (el menú lo restringe)
        $this->inventarioReal->agregarAuto($auto);
    }

    public function actualizarAuto(int $id, string $nuevoAuto): void {
        // Solo el admin puede llegar aquí
        $this->inventarioReal->actualizarAuto($id, $nuevoAuto);
    }

    public function listarAutos(): array {
        return $this->inventarioReal->listarAutos();
    }
}
?>