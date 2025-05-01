<?php
namespace app\modelo;

require_once 'Pago.php';
require_once 'Pago_Paypal.php';



class Pago_Paypal_Adapter extends Pago implements Pago_Paypal {
    protected $field1;
    protected $field2;

    public function __construct($type, $field1, $field2) {
        parent::__construct($type);
        $this->field1 = $field1;
        $this->field2 = $field2;
    }

    public function realizarPago() {
        return $this->realizarPago_Paypal();
    }

    public function realizarPago_Paypal() {
        return "<br><br>Pago realizado con PayPal. <br> Cliente: {$this->field1}<br>Auto vendido: {$this->field2}";
    }
}
