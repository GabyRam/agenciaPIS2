<?php
namespace app\servicios\Usuario\Inventario;

class FuncionesInventario {
    public static function seleccionCorrespondiente(ProxyInventario $proxy, int $id): ?string {
        $autos = $proxy->listarAutos();
        return $autos[$id] ?? null;
    }
}
?>