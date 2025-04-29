<?php
require_once 'Factura.php';

class FacturaRecapitulativa extends Factura {
    private $cantidadProducto;

    public function __construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma, $cantidadProducto) {
        parent::__construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma);
        $this->cantidadProducto = $cantidadProducto;
    }

    public function visualizarFactura() {
        echo "<h3>Factura Recapitulativa</h3>";
        echo "Clave Registro: $this->claveRegistro<br>";
        echo "Folio: $this->folio<br>";
        echo "Receptor: $this->receptor<br>";
        echo "Producto: $this->producto<br>";
        echo "Cuenta Bancaria: $this->cuentaBancaria<br>";
        echo "Firma: $this->firma<br>";
        echo "Cantidad Producto: $this->cantidadProducto<br>";
    }
}
