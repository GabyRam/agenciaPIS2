<?php
namespace app\vista;

interface IInventario {
    public function agregarAuto(string $modelo): void;
    public function actualizarAuto(int $id, string $nuevoModelo): void;
    public function listarAutos(): array;
}
?>
