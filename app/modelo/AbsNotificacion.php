<?php
namespace app\modelo;

abstract class AbsNotificacion
{
    protected INotificador $notificador;

    public function __construct(INotificador $notificador)
    {
        $this->notificador = $notificador;
    }

    abstract public function notificar(string $mensaje): void;
}
