<?php
namespace app\servicios\Usuario\Notificaciones;
use app\servicios\Usuario\Notificaciones\ImplementacionNotificacion;

class NotificacionInformativa implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion informativa'>$mensaje</div>";
    }
}
