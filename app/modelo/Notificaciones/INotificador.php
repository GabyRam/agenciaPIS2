<?php
namespace app\modelo\Notificaciones;

interface INotificador
{
    public function enviarNotificacion(string $mensaje): void;
}
