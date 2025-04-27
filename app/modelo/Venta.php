<?php
namespace app\modelo;

use app\vista\IVenta;

class Venta implements IVenta {
    public function procesarVenta() {
        echo "Procesando venta básica de auto.\n";
    }
}
?>
