<?php
class UI_ActualizacionExistencias {
    public static function mostrar(ProxyInventario $proxy) {
        echo "\n--- ACTUALIZAR AUTO ---\n";
        $autos = $proxy->listarAutos();
        foreach ($autos as $id => $auto) {
            echo "[$id] $auto\n";
        }
        echo "ID del auto a modificar: ";
        $id = intval(trim(fgets(STDIN)));
        echo "Nuevo modelo: ";
        $nuevoAuto = trim(fgets(STDIN));
        $proxy->actualizarAuto($id, $nuevoAuto);
    }
}
?>