<?php
namespace app\servicios;

class NotificacionInformativa implements ImplementacionNotificacion
{
    public function enviar(string $mensaje): void
    {
        echo "<div class='notificacion informativa'>$mensaje</div>";
    }
}
