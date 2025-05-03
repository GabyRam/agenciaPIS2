<?php
namespace app\servicios\Usuario\Notificaciones;

interface ImplementacionNotificacion
{
    public function enviar(string $mensaje): void;
}
