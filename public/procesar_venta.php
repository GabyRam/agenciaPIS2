<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/BD/database.php';

// Incluir las clases del sistema de pagos
require_once __DIR__ . '/../app/controlador/Pago/PagoController.php';
require_once __DIR__ . '/../app/modelo/Pago/Pago_Credito.php';
require_once __DIR__ . '/../app/modelo/Pago/Pago_Contado.php';
require_once __DIR__ . '/../app/modelo/Pago/Pago_Paypal_Adapter.php';
require_once __DIR__ . '/../app/modelo/Usuario/Cliente.php';

use app\servicios\BD\Database;
use app\controlador\Pago\PagoController;
use app\modelo\Usuario\Cliente;

// Iniciar sesión para almacenar datos
session_start();

// Conexión a la base de datos
$db = Database::getConnection();

// Recuperar datos del auto
function obtenerAuto($idAuto, $db) {
    $queryAuto = "SELECT * FROM app.auto WHERE ID_Auto = $1";
    $resultAuto = pg_query_params($db, $queryAuto, [$idAuto]);
    return pg_fetch_assoc($resultAuto);
}


// --- FUNCIONES DE INSERCIÓN EN BD ---
function insertarPersona($nombre, $db) {
    $query = "INSERT INTO Personas (Nombre, Apellido_Paterno) VALUES ($1, 'Desconocido') RETURNING ID_Persona";
    $result = pg_query_params($db, $query, [$nombre]);
    return pg_fetch_assoc($result)['id_persona'];
}

function insertarCliente($idPersona, $db) {
    $query = "INSERT INTO Clientes (ID_Persona) VALUES ($1)";
    pg_query_params($db, $query, [$idPersona]);
}

function insertarTrabajador($idPersona, $db) {
    $puestoDefault = 1;
    $query = "INSERT INTO Trabajadores (ID_Persona, ID_Puesto) VALUES ($1, $2) RETURNING ID_Trabajador";
    $result = pg_query_params($db, $query, [$idPersona, $puestoDefault]);
    return pg_fetch_assoc($result)['id_trabajador'];
}


function insertarPago($idPersona, $db) {
    $numPago = uniqid("PG");
    $query = "INSERT INTO Pagos (ID_Persona, Numero_Pago) VALUES ($1, $2) RETURNING ID_Pago";
    $result = pg_query_params($db, $query, [$idPersona, $numPago]);
    return pg_fetch_assoc($result)['id_pago'];
}

function insertarVenta($idAuto, $idPostVenta, $idPersona, $idTrabajador, $idPago, $db) {
    $query = "INSERT INTO Venta (ID_Carro, ID_Post_Venta, ID_Persona, ID_Trabajador, ID_Pago) 
              VALUES ($1, $2, $3, $4, $5)";
    pg_query_params($db, $query, [$idAuto, $idPostVenta, $idPersona, $idTrabajador, $idPago]);
}

// --- PROCESAMIENTO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del cliente, vendedor, pago, y auto
    $clienteNombre = htmlspecialchars($_POST['cliente']);
    $vendedorNombre = htmlspecialchars($_POST['vendedor']);
    $pagoMetodo = strtolower(trim(htmlspecialchars($_POST['pago'])));
    $idAuto = htmlspecialchars($_POST['id_auto']);

    // Insertar cliente
    $idClientePersona = insertarPersona($clienteNombre, $db);
    insertarCliente($idClientePersona, $db);

    // Insertar vendedor
    $idVendedorPersona = insertarPersona($vendedorNombre, $db);
    $idTrabajador = insertarTrabajador($idVendedorPersona, $db);

    // Insertar pago
    $idPago = insertarPago($idClientePersona, $db);

    // Insertar venta
    $idPostVenta = null;  // Esto debería estar correctamente definido si es necesario
    insertarVenta($idAuto, $idPostVenta, $idClientePersona, $idTrabajador, $idPago, $db);

    // Actualizar disponibilidad del auto en la base de datos
    pg_query_params($db, "UPDATE app.auto SET Disponibilidad = false, Apartado = true WHERE ID_Auto = $1", [$idAuto]);

    // Obtener los datos del auto y almacenarlos en la sesión
    $auto = obtenerAuto($idAuto, $db);
    $_SESSION['auto'] = $auto;  // Guardamos los datos del auto en la sesión

    // --- APLICAMOS PATRONES DE PAGO ---
    $cliente = new Cliente($idClientePersona, $idClientePersona);  // Usamos ID de persona
    $controller = new PagoController();

    // Realizar pago
    $resultado = $controller->realizarPago(
        $cliente->id_cliente,
        $cliente->id_persona,
        $pagoMetodo,
        [
            'type' => 'CompraAuto',
            'field1' => $clienteNombre,
            'field2' => $idAuto
        ]
    );

    // --- MOSTRAR CONFIRMACIÓN ---
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Compra Realizada</title>
        <link rel="stylesheet" href="styles/comprar.css">
    </head>
    <body>
        <div class="formulario">
            <h1>✅ Compra Realizada</h1>
            <p><strong>Cliente:</strong> <?= $clienteNombre ?></p>
            <p><strong>Vendedor:</strong> <?= $vendedorNombre ?></p>
            <p><strong>ID Auto:</strong> <?= $idAuto ?></p>
            <p><strong>Método de Pago:</strong> <?= ucfirst($pagoMetodo) ?></p>
            <hr>
            <p><strong>Resultado:</strong> <?= $resultado ?></p>

            <a href="index.php">⬅️ Volver al catálogo</a>
            <a href="factura.php">➡️ Facturar</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>❌ Método no permitido.</p>";
}
?>