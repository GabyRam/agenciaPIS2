<?php
namespace app\modelo\Venta;

class Venta_Vendedor extends VentaDecorator {
    public function procesarVenta() {
        $this->venta->procesarVenta();
        echo "Registrando vendedor que atendió la venta.\n";
    }
}
?>
