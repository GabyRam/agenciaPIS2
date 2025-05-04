<?php
namespace app\servicios\Usuario\Facturas;

class FacturaRecapitulativa extends FacturaAbstracta {
    public function visualizarFactura(): void {
        echo "Factura Recapitulativa: {$this->contenido}\n";
    }

    public function setFactura(string $contenido): void {
        $this->contenido = $contenido;
    }
}

