<?php
session_start();

// Obtener datos del auto desde sesión
if (isset($_SESSION['auto'])) {
    $auto = $_SESSION['auto'];
    $modelo = $auto['modelo'];
    $anio = $auto['anio'];
    $costo = $auto['costo'];
    $capacidad = $auto['capacidad'];
    $cilindros = $auto['cilindros'];
} else {
    $modelo = $anio = $costo = $capacidad = $cilindros = "No disponible";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Factura</title>
    <link rel="stylesheet" href="styles/factura.css">
</head>
<body>
    <div class="factura-box">
        <h1>Generar Factura</h1>

        <form action="procesando_factura.php" method="post">
            <label for="tipo_factura">Selecciona el tipo de factura:</label>
            <select name="tipo_factura" id="tipo_factura">
                <option value="ordinaria">Ordinaria</option>
                <option value="carta_vehicular">Carta Vehicular</option>
                <option value="recapitulativa">Recapitulativa</option>
            </select>

            <input type="hidden" name="modelo" value="<?= $modelo ?>">
            <input type="hidden" name="anio" value="<?= $anio ?>">
            <input type="hidden" name="costo" value="<?= $costo ?>">
            <input type="hidden" name="capacidad" value="<?= $capacidad ?>">
            <input type="hidden" name="cilindros" value="<?= $cilindros ?>">

            <br><br>
            <button type="submit">Generar Factura</button>
        </form>

        <br><a href="index.php">⬅️ Volver al catálogo</a>
    </div>
</body>
</html>
