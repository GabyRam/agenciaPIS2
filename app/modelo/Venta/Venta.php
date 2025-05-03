<?php
namespace app\modelo\Venta;

use app\servicios\Usuario\Venta\IVenta;

class Venta implements IVenta {
    public function procesarVenta() {
        echo "Procesando venta básica de auto.\n";
    }
}
?>
