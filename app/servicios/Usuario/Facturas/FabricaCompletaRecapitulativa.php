<?php
namespace app\servicios\Usuario\Facturas;
use app\servicios\Usuario\Facturas\FacturaAbstracta;
use app\servicios\Usuario\Facturas\FabricaFactura;
use app\servicios\Usuario\Facturas\FacturaRecapitulativa;

class FabricaCompletaRecapitulativa implements FabricaFactura {
    public function crearFactura(): FacturaAbstracta {
        return new FacturaRecapitulativa();
    }
}

