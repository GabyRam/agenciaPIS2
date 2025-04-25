<?php
namespace app\servicios;

use app\modelo\INotificador;

class NotificadorBase implements INotificador
{
    public function enviarNotificacion(string $mensaje): void
    {
        echo "Notificación básica: " . $mensaje . PHP_EOL;
    }
}
