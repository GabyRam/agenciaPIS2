<?php
namespace app\controlador;

use app\servicios\AbstraccionNotificacion;

class NotificacionControlador extends AbstraccionNotificacion
{
    public function notificar(string $mensaje): void
    {
        $this->implementacion->enviar($mensaje);
    }
}
