<?php
namespace app\modelo;

require_once 'Pago.php';

class Pago_Contado extends Pago {

    public function __construct($type) {
        parent::__construct($type);
    }

    public function realizarPago() {
        return $this->realizarPago_Contado();
    }

    public function realizarPago_Contado() {
        return "Pago realizado al Contado de tipo: {$this->type}";
    }
}
