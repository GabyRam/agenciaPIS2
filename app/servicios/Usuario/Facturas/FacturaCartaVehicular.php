<?php
namespace app\servicios\Usuario\Facturas;

class FacturaCartaVehicular extends FacturaAbstracta {
    public function visualizarFactura(): void {
        echo "Factura Carta Vehicular: {$this->contenido}\n";
    }

    public function setFactura(string $contenido): void {
        $this->contenido = $contenido;
    }
}

