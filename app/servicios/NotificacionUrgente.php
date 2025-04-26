<?php
namespace app\servicios;

class NotificacionUrgente implements Notificacion {
    public function enviar(string $mensaje) {
        echo "<div class='notificacion urgente'>🔴 URGENTE: $mensaje</div>";
    }
}
