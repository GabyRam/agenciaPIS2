<?php
namespace app\servicios\Usuario\Notificaciones;
use app\servicios\Usuario\Notificaciones\ImplementacionNotificacion;

class NotificacionRecordatorio implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion recordatorio'>$mensaje</div>";
    }
}
