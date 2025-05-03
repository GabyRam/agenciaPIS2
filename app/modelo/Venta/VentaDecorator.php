<?php
namespace app\modelo\Venta;

use app\servicios\Usuario\Venta\IVenta;

abstract class VentaDecorator implements IVenta {
    protected $venta;

    public function __construct(IVenta $venta) {
        $this->venta = $venta;
    }

    abstract public function procesarVenta();
}
?>
