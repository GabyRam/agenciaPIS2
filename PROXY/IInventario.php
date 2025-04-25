<?php
interface IInventario {
    public function agregarAuto(string $auto): void;
    public function actualizarAuto(int $id, string $nuevoAuto): void;
    public function listarAutos(): array;
}
?>
