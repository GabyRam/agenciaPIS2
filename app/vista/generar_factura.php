<?php
namespace app\vista;

use Exception;
use app\controlador\FacturaController;


$controller = new FacturaController();

try {
    
    $idPago = 123; 
    $clienteNombre = 'Juan Pérez';
    $clienteRFC = 'JUAP800101XXX';
    $fecha = date('Y-m-d');
    $monto = 15999.99;
    $tipoFactura = 'FacturaOrdinaria';

    $resultado = $controller->generarFactura($idPago, $clienteNombre, $clienteRFC, $fecha, $monto, $tipoFactura);

    echo $resultado;
} catch (Exception $e) {
    echo "Error al generar la factura: " . $e->getMessage();
}
