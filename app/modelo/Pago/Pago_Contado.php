<?php
namespace app\modelo\Pago;

require_once 'Pago.php';

class Pago_Contado extends Pago {

    public function __construct($type) {
        parent::__construct($type);
    }

    public function realizarPago() {
        return $this->realizarPago_Contado();
    }

    public function realizarPago_Contado() {
        return "<br><br>Pago realizado al Contado de tipo: {$this->type}";
    }
}
