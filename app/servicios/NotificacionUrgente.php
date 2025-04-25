<?php
namespace app\servicios;

class NotificacionUrgente implements Notificacion {
    public function enviar(string $mensaje) {
        echo "🔴 URGENTE: $mensaje<br>";
    }
}
