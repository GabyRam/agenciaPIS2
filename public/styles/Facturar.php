<?php 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';

use app\servicios\Database;

$db = Database::getConnection();

if (isset($_GET['id_pago'])) {
    $idPago = htmlspecialchars($_GET['id_pago']);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Facturar Pago</title>
        <link rel="stylesheet" href="styles/facturar.css">
    </head>
    <body>

        <div class="formulario">
            <h1>🧾 Generar Factura de Pago</h1>
            <p>Estás generando una factura para el pago con ID: <strong><?= $idPago ?></strong></p>

            <form action="procesar_factura.php" method="POST">
                <input type="hidden" name="id_pago" value="<?= $idPago ?>">
                
                <label>Nombre del Cliente:</label>
                <input type="text" name="cliente" required>

                <label>RFC del Cliente:</label>
                <input type="text" name="rfc" required>

                <label>Fecha de Factura:</label>
                <input type="date" name="fecha" required>

                <label>Monto del Pago:</label>
                <input type="number" name="monto" step="0.01" required>

                <label>Tipo de Factura:</label>
                <select name="tipo_factura" required>
                    <option value="">-- Seleccionar tipo de factura --</option>
                    <option value="FacturaCartaVehicular">Factura Carta Vehicular</option>
                    <option value="FacturaOrdinaria">Factura Ordinaria</option>
                    <option value="FacturaRecapitulativa">Factura Recapitulativa</option>
                </select>

                <button type="submit">Generar Factura</button>
            </form>

            <a href="index.php">⬅️ Volver al listado</a>
        </div>

    </body>
    </html>

    <?php
} else {
    echo "<p>❌ No se seleccionó ningún pago para facturar.</p>";
    echo "<a href='index.php'>Volver al listado</a>";
}
