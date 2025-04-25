<?php
// Configuración
require_once __DIR__ . '/../config/config.php';

// Servicios
require_once __DIR__ . '/../app/servicios/Database.php';
require_once __DIR__ . '/../app/servicios/Notificacion.php';
require_once __DIR__ . '/../app/servicios/NotificacionUrgente.php';
require_once __DIR__ . '/../app/servicios/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/NotificacionRecordatorio.php';

// Controlador de Notificaciones
require_once __DIR__ . '/../app/controlador/NotificacionControlador.php';

// Clases de Venta
require_once __DIR__ . '/../app/vista/IVenta.php';
require_once __DIR__ . '/../app/modelo/Venta.php';
require_once __DIR__ . '/../app/modelo/VentaDecorator.php';
require_once __DIR__ . '/../app/modelo/Venta_Cliente.php';
require_once __DIR__ . '/../app/modelo/Venta_Vendedor.php';
require_once __DIR__ . '/../app/modelo/Venta_Pago.php';

// Controlador de Venta
require_once __DIR__ . '/../app/controlador/VentaControlador.php';

use app\modelo\AbsNotificacion;
use app\vista\INotificador;
use app\servicios\Database;
use app\servicios\NotificacionUrgente;
use app\servicios\NotificacionInformativa;
use app\servicios\NotificacionRecordatorio;
use app\controlador\NotificacionControlador;
use app\controlador\VentaControlador;

// Probar conexión
$db = Database::getConnection();
echo "🚀 Conexión exitosa!<br><br>";

// Ejemplos de uso de Notificaciones
$urgente = new NotificacionControlador(new NotificacionUrgente());
$urgente->notificar("¡Atención inmediata requerida!");

$informativa = new NotificacionControlador(new NotificacionInformativa());
$informativa->notificar("Se realizará mantenimiento esta noche.");

$recordatorio = new NotificacionControlador(new NotificacionRecordatorio());
$recordatorio->notificar("No olvides enviar el reporte semanal.");

// Ejemplo de uso de Venta
echo "<br>🚗 Procesando venta:<br>";
$ventaControlador = new VentaControlador();
$ventaControlador->realizarVenta();
?>
