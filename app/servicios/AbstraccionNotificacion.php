<?php
namespace app\servicios;

abstract class AbstraccionNotificacion
{
    protected $implementacion;

    public function __construct(ImplementacionNotificacion $implementacion)
    {
        $this->implementacion = $implementacion;
    }

    abstract public function notificar(string $mensaje): void;
}
