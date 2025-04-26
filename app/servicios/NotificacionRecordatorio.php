<?php
namespace app\servicios;

class NotificacionRecordatorio implements Notificacion {
    public function enviar(string $mensaje) {
        echo "<div class='notificacion recordatorio'>🔵 RECORDATORIO: $mensaje</div>";
    }
}
