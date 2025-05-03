<?php
namespace app\modelo\Usuario;

use app\modelo\Pago\Pago;

class Cliente {
    public $id_cliente;
    public $id_persona;

    public function __construct($id_cliente, $id_persona) {
        $this->id_cliente = $id_cliente;
        $this->id_persona = $id_persona;
    }

    public function pagar(Pago $pago) {
        return $pago->realizarPago();
    }
}
