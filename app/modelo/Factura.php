<?php

abstract class Factura {
    protected $claveRegistro;
    protected $folio;
    protected $receptor;
    protected $producto;
    protected $cuentaBancaria;
    protected $firma;

    public function __construct($claveRegistro, $folio, $receptor, $producto, $cuentaBancaria, $firma) {
        $this->claveRegistro = $claveRegistro;
        $this->folio = $folio;
        $this->receptor = $receptor;
        $this->producto = $producto;
        $this->cuentaBancaria = $cuentaBancaria;
        $this->firma = $firma;
    }

    abstract public function visualizarFactura();
}
