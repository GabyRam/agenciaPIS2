<?php
namespace app\modelo\Facturas;
use app\servicios\Usuario\Facturas\FabricaFactura;
use app\servicios\Usuario\Facturas\FacturaAbstracta;

class Pago {
    private FacturaAbstracta $factura;

    public function realizarPago(): void {
        echo "Pago realizado.\n";
    }

    public function solicitarCreacionDeFactura(FabricaFactura $fabrica): void {
        $this->factura = $fabrica->crearFactura();
    }

    public function recibirFactura(string $contenido): void {
        $this->factura->setFactura($contenido);
        $this->factura->visualizarFactura();
    }
}
