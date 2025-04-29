<?php
namespace app\vista;

use Exception;
use app\controlador\PagoController;

$controller = new PagoController();

try {
    $resultado = $controller->realizarPago(1, 1001, 'paypal', [
        'type' => 'Online',
        'field1' => 'email@example.com',
        'field2' => 'transaction123'
    ]);

    echo $resultado;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
