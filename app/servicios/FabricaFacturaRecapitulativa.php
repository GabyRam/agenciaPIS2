<?php
require_once 'FabricaAbstractaFactura.php';
require_once 'FacturaRecapitulativa.php';

class FabricaFacturaRecapitulativa extends FabricaAbstractaFactura {
    public function crearFactura(...$params) {
        return new FacturaRecapitulativa(...$params);
    }
}
