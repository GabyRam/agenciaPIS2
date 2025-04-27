<?php
namespace app\servicios;

interface ImplementacionNotificacion
{
    public function enviar(string $mensaje): void;
}
