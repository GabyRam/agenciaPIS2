<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';

use app\servicios\Database;

$db = Database::getConnection();

if (isset($_GET['id_auto'])) {
    $idAuto = htmlspecialchars($_GET['id_auto']);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Comprar Auto</title>
        <link rel="stylesheet" href="styles/comprar.css">
    </head>
    <body>

        <div class="formulario">
            <h1>🚘 Comprar Auto</h1>
            <p>Estás a punto de comprar el auto con ID: <strong><?= $idAuto ?></strong></p>

            <form action="procesar_venta.php" method="POST">
                <input type="hidden" name="id_auto" value="<?= $idAuto ?>">
                
                <label>Nombre del Cliente:</label>
                <input type="text" name="cliente" required>

                <label>Nombre del Vendedor:</label>
                <input type="text" name="vendedor" required>

                <label>Método de Pago:</label>
                <input type="text" name="pago" required>

                <button type="submit">Confirmar Compra</button>
            </form>

            <a href="index.php">⬅️ Volver al catálogo</a>
        </div>

    </body>
    </html>

    <?php
} else {
    echo "<p>❌ No se seleccionó ningún auto.</p>";
    echo "<a href='index.php'>Volver al catálogo</a>";
}
