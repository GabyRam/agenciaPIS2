<?php
namespace app\servicios;

class NotificacionInformativa implements Notificacion {
    public function enviar(string $mensaje) {
        echo "🟡 INFO: $mensaje<br>";
    }
}
