<?php
namespace app\servicios\Usuario\Facturas;

class FacturaOrdinaria extends FacturaAbstracta {
    public function visualizarFactura(): void {
        echo "Factura Ordinaria: {$this->contenido}\n";
    }

    public function setFactura(string $contenido): void {
        $this->contenido = $contenido;
    }
}
