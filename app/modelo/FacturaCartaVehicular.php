<?php
require_once 'Factura.php';

class FacturaCartaVehicular extends Factura {
    private $plazo;
    private $monto;

    public function __construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma, $plazo, $monto) {
        parent::__construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma);
        $this->plazo = $plazo;
        $this->monto = $monto;
    }

    public function visualizarFactura() {
        echo "<h3>Factura Carta Vehicular</h3>";
        echo "Clave Registro: $this->claveRegistro<br>";
        echo "Folio: $this->folio<br>";
        echo "Receptor: $this->receptor<br>";
        echo "Producto: $this->producto<br>";
        echo "Cuenta Bancaria: $this->cuentaBancaria<br>";
        echo "Firma: $this->firma<br>";
        echo "Plazo: $this->plazo<br>";
        echo "Monto: $this->monto<br>";
    }
}
