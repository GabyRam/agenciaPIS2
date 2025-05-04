<?php
// --- INCLUIR CLASES NECESARIAS ---
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/BD/Database.php';
require_once __DIR__ . '/../app/modelo/Inventario/IInventario.php';
require_once __DIR__ . '/../app/servicios/Usuario/Inventario/InventarioReal.php';
require_once __DIR__ . '/../app/servicios/Usuario/Inventario/ProxyInventario.php';
require_once __DIR__ . '/../app/servicios/Usuario/Notificaciones/AbstraccionNotificacion.php';
require_once __DIR__ . '/../app/servicios/Usuario/Notificaciones/ImplementacionNotificacion.php';
require_once __DIR__ . '/../app/servicios/Usuario/Notificaciones/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/Usuario/Notificaciones/NotificacionRecordatorio.php';
require_once __DIR__ . '/../app/servicios/Usuario/Notificaciones/NotificacionUrgente.php';
require_once __DIR__ . '/../app/controlador/Notificaciones/NotificacionControlador.php';

require_once __DIR__ . '/../app/modelo/Auto/Catalogo.php';
require_once __DIR__ . '/../app/modelo/Auto/Hibrido.php';
require_once __DIR__ . '/../app/modelo/Auto/Camioneta.php';
require_once __DIR__ . '/../app/modelo/Auto/Deportivo.php';
require_once __DIR__ . '/../app/modelo/Auto/Electrico.php';
require_once __DIR__ . '/../app/modelo/Usuario/Gerente.php';

// --- FACTURAS ---
require_once __DIR__ . '/../app/modelo/Facturas/Pago.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaFactura.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaAbstracta.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaFacturaOrd.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaFacturaCartaVehicular.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaRecapitulativa.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaOrdinaria.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaCartaVehicular.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaRecapitulativa.php';


use app\servicios\BD\Database;
use app\controlador\Notificaciones\NotificacionControlador;
use app\servicios\Usuario\Notificaciones\NotificacionInformativa;
use app\servicios\Usuario\Notificaciones\NotificacionRecordatorio;
use app\servicios\Usuario\Notificaciones\NotificacionUrgente;
use app\modelo\Auto\Catalogo;
use app\modelo\Auto\Hibrido;
use app\modelo\Auto\Camioneta;
use app\modelo\Auto\Deportivo;
use app\modelo\Auto\Electrico;
use app\modelo\Usuario\Gerente;
use app\modelo\Facturas\Pago;
use app\servicios\Usuario\Facturas\FabricaCompletaFacturaOrd;
use app\servicios\Usuario\Facturas\FabricaCompletaFacturaCartaVehicular;
use app\servicios\Usuario\Facturas\FabricaCompletaRecapitulativa;


// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$route = $_GET['route'] ?? 'catalogo';

try {
    switch ($route) {
        case 'inventario':
            require __DIR__ . '/GestionInventario.php';
            break;

        case 'catalogo':
        default:
            $db = Database::getConnection();
            pg_query($db, "SET search_path TO app");

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

            // Crear objetos de autos
            $hibrido = new Hibrido("Toyota", "Prius", 30000);
            $camioneta = new Camioneta("Honda", "CRV", 45000);
            $deportivo = new Deportivo("Ford", "Mustang", 250000);
            $electrico = new Electrico("BYD", "Dolphin", 60000);

            // Crear catálogo
            $catalogo = new Catalogo($hibrido, $camioneta, $deportivo, $electrico);

            // Crear gerente
            $gerente = new Gerente("Juan Pérez", "juan@autos.com");

            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Prime - Wheels</title>
                <link rel="stylesheet" href="styles/encabezado.css">
                <link rel="stylesheet" href="styles/catalogo.css">
                <link rel="stylesheet" href="styles/catalogoVista.css">
                <link rel="stylesheet" href="styles/notificaciones.css">
                <link rel="stylesheet" href="styles/menu.css">
                <link rel="stylesheet" href="styles/factura.css">
                <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
            </head>
            <body>
                <header>
                    <h1>P r i m e - W h e e l s</h1>
                </header>

                <nav class="menu">
                    <ul>
                        <li><a href="#" onclick="mostrar('catalogo'); return false;">Ver Catálogo</a></li>
                        <li><a href="index.php?route=inventario&action=gestionar">Gestionar Inventario</a></li>
                    </ul>
                </nav>

                <div id="inventario" style="display: block;">
                    <div class="catalogo">
                        <?php
                        $result = pg_query($db, "SELECT * FROM Auto WHERE Disponibilidad = true");
                        while ($row = pg_fetch_assoc($result)) {
                            echo '
                            <div class="card">
                                <img src="img/default-car.png" alt="Auto disponible">
                                <div class="info">
                                    <h2>Año ' . htmlspecialchars($row['anio'] ?? '') . '</h2>
                                    <p><strong>Costo:</strong> $' . number_format($row['costo'] ?? 0, 2) . '</p>
                                    <p><strong>Capacidad:</strong> ' . htmlspecialchars($row['capacidad'] ?? '') . ' personas</p>
                                    <p><strong>Cilindros:</strong> ' . htmlspecialchars($row['cilindros'] ?? '') . '</p>
                                    <p><strong>Apartado:</strong> ' . ($row['apartado'] ? 'Sí' : 'No') . '</p>
                                    <form action="comprar.php" method="GET">
                                        <input type="hidden" name="id_auto" value="' . htmlspecialchars($row['id_auto'] ?? '') . '">
                                        <button type="submit" class="btn-comprar">Comprar</button>
                                    </form>
                                </div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>

                <div id="catalogo" style="display: none; padding: 20px; font-size: 25px;">
                    <h2 style="text-align: center; margin-bottom: 20px;">Catálogo 2025</h2>
                    <div class="catalogo-lista" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                        <?php
                        echo $gerente->consultarCatalogo($catalogo);
                        ?>
                    </div>
                    <a href="index.php" style="display: block; text-align: center; font-size: 18px; margin-top: 20px;">⬅️ Volver al catálogo</a>
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

                            setTimeout(() => {
                                const noti = contenedor.querySelector('.notificacion');
                                if (noti) noti.remove();
                            }, 5000);
                        }

                        setInterval(mostrarNotificacion, 3000);

                        function mostrar(seccion) {
                            document.getElementById('inventario').style.display = (seccion === 'inventario') ? 'block' : 'none';
                            document.getElementById('catalogo').style.display = (seccion === 'catalogo') ? 'block' : 'none';
                        }
                    </script>
                </div>
            </body>
            </html>
            <?php
            break;
    }
} catch (\Throwable $e) {
    echo "<p>Error en la aplicación: " . $e->getMessage() . "</p>";
}
?>
