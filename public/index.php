<?php
// Configuración
require_once __DIR__ . '/../config/config.php';

// Servicios
require_once __DIR__ . '/../app/servicios/Database.php';
require_once __DIR__ . '/../app/servicios/Notificacion.php';
require_once __DIR__ . '/../app/servicios/NotificacionUrgente.php';
require_once __DIR__ . '/../app/servicios/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/NotificacionRecordatorio.php';

// Controlador
require_once __DIR__ . '/../app/controlador/NotificacionControlador.php';

use app\servicios\Database;
use app\servicios\NotificacionUrgente;
use app\servicios\NotificacionInformativa;
use app\servicios\NotificacionRecordatorio;
use app\controlador\NotificacionControlador;

// Probar conexión
$db = Database::getConnection();
echo "🚀 Conexión exitosa!<br><br>";

// Ejemplos de uso
$urgente = new NotificacionControlador(new NotificacionUrgente());
$urgente->notificar("¡Atención inmediata requerida!");

$informativa = new NotificacionControlador(new NotificacionInformativa());
$informativa->notificar("Se realizará mantenimiento esta noche.");

$recordatorio = new NotificacionControlador(new NotificacionRecordatorio());
$recordatorio->notificar("No olvides enviar el reporte semanal.");
