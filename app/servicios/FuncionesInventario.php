<?php
namespace app\servicios;

class FuncionesInventario {
    public static function seleccionCorrespondiente(\app\servicios\ProxyInventario $proxy, int $id): ?string {
        $autos = $proxy->listarAutos();
        return $autos[$id] ?? null;
    }
}
?>