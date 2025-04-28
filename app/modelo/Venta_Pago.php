<?php
namespace app\modelo;

class Venta_Pago extends VentaDecorator {
    public function procesarVenta() {
        $this->venta->procesarVenta();
        echo "Confirmando método de pago y registrándolo.\n";
    }
}
?>
