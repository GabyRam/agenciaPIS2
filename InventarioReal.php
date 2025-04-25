<?php
class InventarioReal implements IInventario {
    private $autos;

    public function __construct(array &$autos) {
        $this->autos = &$autos;
    }

    public function agregarAuto(string $auto): void {
        $this->autos[] = $auto;
    }

    public function actualizarAuto(int $id, string $nuevoAuto): void {
        if (isset($this->autos[$id])) {
            $this->autos[$id] = $nuevoAuto;
        }
    }

    public function listarAutos(): array {
        return $this->autos;
    }
}
?>