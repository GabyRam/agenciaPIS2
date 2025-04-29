<?php
// --- INCLUIR CLASES NECESARIAS ---
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';
require_once __DIR__ . '/../app/vista/IInventario.php';
require_once __DIR__ . '/../app/vista/generar_factura.php';
require_once __DIR__ . '/../app/servicios/InventarioReal.php';
require_once __DIR__ . '/../app/servicios/ProxyInventario.php';
require_once __DIR__ . '/../app/servicios/AbstraccionNotificacion.php';
require_once __DIR__ . '/../app/servicios/ImplementacionNotificacion.php';
require_once __DIR__ . '/../app/servicios/NotificacionInformativa.php';
require_once __DIR__ . '/../app/servicios/NotificacionRecordatorio.php';
require_once __DIR__ . '/../app/servicios/NotificacionUrgente.php';
require_once __DIR__ . '/../app/servicios/FabricaAbstractaFactura.php';
require_once __DIR__ . '/../app/servicios/FabricaFacturaCartaVehicular.php';
require_once __DIR__ . '/../app/servicios/FabricaFacturaOrdinaria.php';
require_once __DIR__ . '/../app/servicios/FabricaFacturaRecapitulativa.php';
require_once __DIR__ . '/../app/controlador/NotificacionControlador.php';
require_once __DIR__ . '/../app/controlador/FacturaController.php';

// Requiere las clases de modelo para el catálogo de objetos
require_once __DIR__ . '/../app/modelo/Catalogo.php';
require_once __DIR__ . '/../app/modelo/Hibrido.php';
require_once __DIR__ . '/../app/modelo/Camioneta.php';
require_once __DIR__ . '/../app/modelo/Deportivo.php';
require_once __DIR__ . '/../app/modelo/Electrico.php';
require_once __DIR__ . '/../app/modelo/Gerente.php';
require_once __DIR__ . '/../app/modelo/Factura.php';
require_once __DIR__ . '/../app/modelo/FacturaCartaVehicular.php';
require_once __DIR__ . '/../app/modelo/FacturaOrdinaria.php';
require_once __DIR__ . '/../app/modelo/FacturaRecapitulativa.php';

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
use app/modelo/Factura;
use app/modelo/FacturaCartaVehicular;
use app/modelo/FacturaOrdinaria;
use app/modelo/FacturaRecapitulativa;
    
// Iniciar sesión globalmente
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
                <link rel="stylesheet" href="styles/menu.css"> <!-- Nueva hoja para la parte de menú -->
            </head>
            <body>
                <header>
                    <h1>🚗 Prime - Wheels</h1>
                </header>

                <div class="menu">
                    <button onclick="location.href='index.php?route=inventario&action='" class="button">Gestionar Inventario</button>
                    <button onclick="mostrar('catalogo')">Ver Catálogo Objetos</button>
                </div>

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
                        // Asumiendo que consultarCatalogo devuelve una lista de objetos o datos para crear tarjetas
                        $catalogoHtml = $gerente->consultarCatalogo($catalogo); 
                        echo $catalogoHtml;
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
                            }, 8000);
                        }

                        setInterval(mostrarNotificacion, 8000);

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
    // Manejo de errores
}
?>
