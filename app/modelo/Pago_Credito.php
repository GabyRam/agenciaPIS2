<?php
namespace app\modelo;
require_once 'Pago.php';

class Pago_Credito extends Pago {

    public function __construct($type) {
        parent::__construct($type);
    }

    public function realizarPago() {
        return $this->realizarPago_Credito();
    }

    public function realizarPago_Credito() {
        return "<br><br>Pago realizado con Crédito de tipo: {$this->type}";
    }
}
