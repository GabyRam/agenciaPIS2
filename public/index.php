<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';
require_once __DIR__ . '/../app/servicios/AbstraccionNotificacion.php';
require_once __DIR__ . '/../app/servicios/ImplementacionNotificacion.php';
require_once __DIR__ . '/../app/servicios/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/NotificacionRecordatorio.php';
require_once __DIR__ . '/../app/servicios/NotificacionUrgente.php';
require_once __DIR__ . '/../app/controlador/NotificacionControlador.php';

use app\servicios\Database;
use app\controlador\NotificacionControlador;
use app\servicios\NotificacionInformativa;
use app\servicios\NotificacionRecordatorio;
use app\servicios\NotificacionUrgente;

$db = Database::getConnection();

// Captura de notificaciones desde las clases PHP
$notificaciones = [];

ob_start();
(new NotificacionControlador(new NotificacionUrgente()))->notificar("¡Atención inmediata requerida!");
$notificaciones[] = ob_get_clean();

ob_start();
(new NotificacionControlador(new NotificacionInformativa()))->notificar("Hoy se actualiza el sistema.");
$notificaciones[] = ob_get_clean();

ob_start();
(new NotificacionControlador(new NotificacionRecordatorio()))->notificar("Envía tu reporte semanal.");
$notificaciones[] = ob_get_clean();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prime Wheels</title>
    <link rel="stylesheet" href="styles/catalogo.css">
    <link rel="stylesheet" href="styles/notificaciones.css">
</head>
<body>
    <header>
        <h1>🚗 Prime - Wheels</h1>
    </header>

    <div class="catalogo">
        <?php
        $result = pg_query($db, "SELECT * FROM Auto WHERE Disponibilidad = true");
        while ($row = pg_fetch_assoc($result)) {
            echo '
            <div class="card">
                <img src="img/default-car.png" alt="Auto disponible">
                <div class="info">
                    <h2>Año ' . $row['anio'] . '</h2>
                    <p><strong>Costo:</strong> $' . number_format($row['costo'], 2) . '</p>
                    <p><strong>Capacidad:</strong> ' . $row['capacidad'] . ' personas</p>
                    <p><strong>Cilindros:</strong> ' . $row['cilindros'] . '</p>
                    <p><strong>Apartado:</strong> ' . ($row['apartado'] ? 'Sí' : 'No') . '</p>
                    <form action="comprar.php" method="GET">
                        <input type="hidden" name="id_auto" value="' . $row['id_auto'] . '">
                        <button type="submit" class="btn-comprar">Comprar</button>
                    </form>
                </div>
            </div>';
        }
        ?>
    </div>

    <div class="notificaciones" id="notificaciones">
        <script>
            const mensajes = <?php echo json_encode($notificaciones); ?>;

            function mostrarNotificacion() {
                const indice = Math.floor(Math.random() * mensajes.length);
                const contenedor = document.getElementById('notificaciones');

                const div = document.createElement('div');
                div.innerHTML = mensajes[indice];
                contenedor.appendChild(div.firstChild);

                // Eliminar la notificación después de unos segundos
                setTimeout(() => {
                    const noti = contenedor.querySelector('.notificacion');
                    if (noti) noti.remove();
                }, 8000);
            }

            // Mostrar una notificación aleatoria cada 10 segundos
            setInterval(mostrarNotificacion, 8000);
        </script>
    </div>
</body>
</html>
