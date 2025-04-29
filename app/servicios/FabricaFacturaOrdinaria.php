<?php
require_once 'FabricaAbstractaFactura.php';
require_once 'FacturaOrdinaria.php';

class FabricaFacturaOrdinaria extends FabricaAbstractaFactura {
    public function crearFactura(...$params) {
        return new FacturaOrdinaria(...$params);
    }
}
