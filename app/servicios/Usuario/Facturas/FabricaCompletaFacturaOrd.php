<?php
namespace app\servicios\Usuario\Facturas;
require_once __DIR__ . '/FabricaFactura.php';
require_once __DIR__ . '/FacturaAbstracta.php';
require_once __DIR__ . '/FacturaOrdinaria.php';

use app\servicios\Usuario\Facturas\FabricaFactura;
use app\servicios\Usuario\Facturas\FacturaAbstracta;
use app\servicios\Usuario\Facturas\FacturaOrdinaria;

class FabricaCompletaFacturaOrd implements FabricaFactura {
    public function crearFactura(): FacturaAbstracta {
        return new FacturaOrdinaria();
    }
}
