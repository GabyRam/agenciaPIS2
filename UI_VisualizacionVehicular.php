<?php
class UI_VisualizacionVehicular {
    public static function mostrar(ProxyInventario $proxy) {
        echo "\n--- AUTOS EN INVENTARIO ---\n";
        foreach ($proxy->listarAutos() as $id => $auto) {
            echo "[$id] $auto\n";
        }
    }
}
?>