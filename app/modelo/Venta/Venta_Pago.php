<?php
namespace app\modelo\Venta;

class Venta_Pago extends VentaDecorator {
    public function procesarVenta() {
        $this->venta->procesarVenta();
        echo "Confirmando método de pago y registrándolo.\n";
    }
}
?>
