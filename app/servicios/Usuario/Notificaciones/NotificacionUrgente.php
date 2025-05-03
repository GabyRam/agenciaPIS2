<?php
namespace app\servicios\Usuario\Notificaciones;
use app\servicios\Usuario\Notificaciones\ImplementacionNotificacion;

class NotificacionUrgente implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion urgente'>$mensaje</div>";
    }
}
