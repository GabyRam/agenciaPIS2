<?php
namespace app\modelo;

class Venta_Vendedor extends VentaDecorator {
    public function procesarVenta() {
        $this->venta->procesarVenta();
        echo "Registrando vendedor que atendió la venta.\n";
    }
}
?>
