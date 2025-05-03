<?php
namespace app\controlador\Notificaciones;

use app\servicios\Usuario\Notificaciones\AbstraccionNotificacion;

class NotificacionControlador extends AbstraccionNotificacion
{
    public function notificar(string $mensaje): void
    {
        $this->implementacion->enviar($mensaje);
    }
}
