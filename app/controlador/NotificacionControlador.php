<?php
namespace app\controlador;

use app\servicios\Notificacion;

class NotificacionControlador {
    private $tipo;

    public function __construct(Notificacion $tipo) {
        $this->tipo = $tipo;
    }

    public function notificar(string $mensaje) {
        $this->tipo->enviar($mensaje);
    }
}
