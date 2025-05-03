<?php
namespace app\controlador\Pago;
use Exception;
use app\modelo\Usuario\Cliente;
use app\modelo\Pago\Pago_Contado;
use app\modelo\Pago\Pago_Credito;
use app\modelo\Pago\Pago_Paypal_Adapter;

class PagoController {

    public function realizarPago($clienteId, $personaId, $tipoPago, $datosPago) {
        $cliente = new Cliente($clienteId, $personaId);

        switch ($tipoPago) {
            case 'credito':
                $pago = new Pago_Credito($datosPago['type']);
                break;
            case 'contado':
                $pago = new Pago_Contado($datosPago['type']);
                break;
            case 'paypal':
                $pago = new Pago_Paypal_Adapter($datosPago['type'], $datosPago['field1'], $datosPago['field2']);
                break;
            default:
                throw new Exception("Tipo de pago no soportado");
        }

        return $cliente->pagar($pago);
    }
}
