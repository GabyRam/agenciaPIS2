<?php
namespace app\modelo;

interface INotificador
{
    public function enviarNotificacion(string $mensaje): void;
}
