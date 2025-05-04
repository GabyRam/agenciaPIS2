<?php
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaFacturaOrd.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaFacturaCartaVehicular.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FabricaCompletaRecapitulativa.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaOrdinaria.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaCartaVehicular.php';
require_once __DIR__ . '/../app/servicios/Usuario/Facturas/FacturaRecapitulativa.php';

use app\servicios\Usuario\Facturas\FabricaCompletaFacturaOrd;
use app\servicios\Usuario\Facturas\FabricaCompletaFacturaCartaVehicular;
use app\servicios\Usuario\Facturas\FabricaCompletaRecapitulativa;

// Recuperar datos del POST
$tipoFactura = $_POST['tipo_factura'] ?? 'ordinaria';
$modelo = $_POST['modelo'] ?? 'No disponible';
$anio = $_POST['anio'] ?? 'No disponible';
$costo = $_POST['costo'] ?? 'No disponible';
$capacidad = $_POST['capacidad'] ?? 'No disponible';
$cilindros = $_POST['cilindros'] ?? 'No disponible';

// Seleccionar la fábrica correspondiente
$fabrica = match ($tipoFactura) {
    'carta_vehicular' => new FabricaCompletaFacturaCartaVehicular(),
    'recapitulativa' => new FabricaCompletaRecapitulativa(),
    default => new FabricaCompletaFacturaOrd(),
};

$factura = $fabrica->crearFactura();

$contenido = "Factura generada para el auto:<br><br>";
$contenido .= "<strong>Modelo:</strong> $modelo<br>";
$contenido .= "<strong>Año:</strong> $anio<br>";
$contenido .= "<strong>Costo:</strong> $$costo<br>";
$contenido .= "<strong>Capacidad:</strong> $capacidad<br>";
$contenido .= "<strong>Cilindros:</strong> $cilindros<br>";

$factura->setFactura($contenido);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Generada</title>
    <link rel="stylesheet" href="styles/factura.css">
</head>
<body>
    <div class="factura-box">
        <h1>📄 Factura Generada</h1>
        <div class="factura-contenido">
            <?php $factura->visualizarFactura(); ?>
        </div>

        <br><a href="index.php">⬅️ Volver al catálogo</a>
    </div>
</body>
</html>
