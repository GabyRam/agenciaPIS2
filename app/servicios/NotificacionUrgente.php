<?php
namespace app\servicios;

class NotificacionUrgente implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion urgente'>$mensaje</div>";
    }
}
