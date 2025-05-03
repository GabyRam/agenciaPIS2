<?php
namespace app\modelo\Venta;

class Venta_Cliente extends VentaDecorator {
    public function procesarVenta() {
        $this->venta->procesarVenta();
        echo "Asociando venta al cliente en la base de datos.\n";
    }
}
?>
