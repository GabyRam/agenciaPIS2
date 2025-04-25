<?php
namespace app\modelo;

use app\vista\IVenta;

abstract class VentaDecorator implements IVenta {
    protected $venta;

    public function __construct(IVenta $venta) {
        $this->venta = $venta;
    }

    abstract public function procesarVenta();
}
?>
