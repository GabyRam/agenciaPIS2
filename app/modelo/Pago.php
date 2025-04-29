<?php
namespace app\modelo;
abstract class Pago {
    protected $type;

    public function __construct($type) {
        $this->type = $type;
    }

    abstract public function realizarPago();
}
