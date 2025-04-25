<?php
namespace app\servicios;

interface Notificacion {
    public function enviar(string $mensaje);
}
