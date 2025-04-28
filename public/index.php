<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';
require_once __DIR__ . '/../app/servicios/AbstraccionNotificacion.php';
require_once __DIR__ . '/../app/servicios/ImplementacionNotificacion.php';
require_once __DIR__ . '/../app/servicios/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/NotificacionRecordatorio.php';
require_once __DIR__ . '/../app/servicios/NotificacionUrgente.php';
require_once __DIR__ . '/../app/controlador/NotificacionControlador.php';

// Requiere las clases de modelo para el catálogo de objetos
require_once __DIR__ . '/../app/modelo/Catalogo.php';
require_once __DIR__ . '/../app/modelo/Hibrido.php';
require_once __DIR__ . '/../app/modelo/Camioneta.php';
require_once __DIR__ . '/../app/modelo/Deportivo.php';
require_once __DIR__ . '/../app/modelo/Electrico.php';
require_once __DIR__ . '/../app/modelo/Gerente.php';

use app\servicios\Database;
use app\controlador\NotificacionControlador;
use app\servicios\NotificacionInformativa;
use app\servicios\NotificacionRecordatorio;
use app\servicios\NotificacionUrgente;
use app\modelo\Catalogo;
use app\modelo\Hibrido;
use app\modelo\Camioneta;
use app\modelo\Deportivo;
use app\modelo\Electrico;
use app\modelo\Gerente;

// Conexión a la base de datos
$db = Database::getConnection();
pg_query($db, "SET search_path TO app");

// Captura de notificaciones
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

// Preparar catálogo de objetos PHP
$catalogo = new Catalogo("Autos 2025");
$catalogo->agregarAuto(new Hibrido("Toyota", "Prius", 30000));
$catalogo->agregarAuto(new Camioneta("Ford", "Ranger", 45000));
$catalogo->agregarAuto(new Deportivo("Ferrari", "F8", 250000));
$catalogo->agregarAuto(new Electrico("Tesla", "Model 3", 60000));
$gerente = new Gerente("Juan Pérez", "juan@autos.com");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prime Wheels</title>
    <link rel="stylesheet" href="styles/catalogo.css">
    <link rel="stylesheet" href="styles/notificaciones.css">
    <style>
        .menu {
            margin: 20px;
            text-align: center;
        }
        .menu button {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        #catalogo p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>🚗 Prime - Wheels</h1>
    </header>

    <div class="menu">
        <button onclick="mostrar('inventario')">Inventario</button>
        <button onclick="mostrar('catalogo')">Catálogo</button>
    </div>

    <!-- Inventario desde la base de datos -->
    <div id="inventario" style="display: block;">
        <div class="catalogo">
            <?php
            $result = pg_query($db, "SELECT * FROM app.auto WHERE Disponibilidad = true");
            while ($row = pg_fetch_assoc($result)) {
                echo '
                <div class="card">
                    <img src="img/default-car.png" alt="Auto disponible">
                    <div class="info">
                        <h2>Año ' . htmlspecialchars($row['anio']) . '</h2>
                        <p><strong>Costo:</strong> $' . number_format($row['costo'], 2) . '</p>
                        <p><strong>Capacidad:</strong> ' . htmlspecialchars($row['capacidad']) . ' personas</p>
                        <p><strong>Cilindros:</strong> ' . htmlspecialchars($row['cilindros']) . '</p>
                        <p><strong>Apartado:</strong> ' . ($row['apartado'] ? 'Sí' : 'No') . '</p>
                        <form action="comprar.php" method="GET">
                            <input type="hidden" name="id_auto" value="' . htmlspecialchars($row['id_auto']) . '">
                            <button type="submit" class="btn-comprar">Comprar</button>
                        </form>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Catálogo desde objetos PHP -->
    <div id="catalogo" style="display: none; text-align: center;">
        <h2>Catálogo 2025</h2>
        <div class="catalogo-lista">
            <pre><?php echo htmlspecialchars($gerente->consultarCatalogo($catalogo)); ?></pre>
        </div>
    </div>

    <!-- Notificaciones -->
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

            setInterval(mostrarNotificacion, 8000);

            // Mostrar y ocultar secciones
            function mostrar(seccion) {
                document.getElementById('inventario').style.display = (seccion === 'inventario') ? 'block' : 'none';
                document.getElementById('catalogo').style.display = (seccion === 'catalogo') ? 'block' : 'none';
            }
        </script>
    </div>
</body>
</html>
