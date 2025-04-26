<?php
namespace app\servicios;

class NotificacionInformativa implements Notificacion {
    public function enviar(string $mensaje) {
        echo "<div class='notificacion informativa'>🟡 INFO: $mensaje</div>";
    }
}
