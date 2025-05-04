<?php
namespace app\servicios\Usuario\Facturas;

abstract class FacturaAbstracta {
    protected string $contenido;

    abstract public function visualizarFactura(): void;
    abstract public function setFactura(string $contenido): void;
}