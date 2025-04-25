<?php
namespace app\servicios;

class NotificacionRecordatorio implements Notificacion {
    public function enviar(string $mensaje) {
        echo "🔵 RECORDATORIO: $mensaje<br>";
    }
}
