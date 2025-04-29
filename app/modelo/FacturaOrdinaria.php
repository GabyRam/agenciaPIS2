<?php
require_once 'Factura.php';

class FacturaOrdinaria extends Factura {
    public function __construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma) {
        parent::__construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma);
    }

    public function visualizarFactura() {
        echo "<h3>Factura Ordinaria</h3>";
        echo "Clave Registro: $this->claveRegistro<br>";
        echo "Folio: $this->folio<br>";
        echo "Receptor: $this->receptor<br>";
        echo "Producto: $this->producto<br>";
        echo "Cuenta Bancaria: $this->cuentaBancaria<br>";
        echo "Firma: $this->firma<br>";
    }
}
