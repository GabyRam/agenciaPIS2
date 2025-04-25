<?php
class UI_RegistroVehicular {
    public static function mostrar(ProxyInventario $proxy) {
        echo "\n--- REGISTRAR AUTO ---\n";
        echo "Modelo del auto: ";
        $auto = trim(fgets(STDIN));
        $proxy->agregarAuto($auto);
    }
}
?>