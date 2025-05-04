<?php
namespace app\servicios\Usuario\Facturas;

class FabricaCompletaFacturaCartaVehicular implements FabricaFactura {
    public function crearFactura(): FacturaAbstracta {
        return new FacturaCartaVehicular();
    }
}

