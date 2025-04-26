<?php
namespace app\servicios;

class NotificacionRecordatorio implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion recordatorio'>$mensaje</div>";
    }
}
