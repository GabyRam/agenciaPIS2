<?php
require_once 'FabricaAbstractaFactura.php';
require_once 'FacturaCartaVehicular.php';

class FabricaFacturaCartaVehicular extends FabricaAbstractaFactura {
    public function crearFactura(...$params) {
        return new FacturaCartaVehicular(...$params);
    }
}
