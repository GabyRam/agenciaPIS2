<?php
namespace app\servicios\Usuario\Facturas;

use app\servicios\Usuario\Facturas\FacturaAbstracta;

interface FabricaFactura {
    public function crearFactura(): FacturaAbstracta;
}