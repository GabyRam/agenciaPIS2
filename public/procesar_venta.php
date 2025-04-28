<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/servicios/Database.php';

use app\servicios\Database;

$db = Database::getConnection();

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
    $puestoDefault = 1; // Asume que existe un puesto con ID 1
    $query = "INSERT INTO Trabajadores (ID_Persona, ID_Puesto) VALUES ($1, $2)";
    pg_query_params($db, $query, [$idPersona, $puestoDefault]);
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

// Obtener datos del formulario
$clienteNombre = $_POST['cliente'];
$vendedorNombre = $_POST['vendedor'];
$pagoMetodo = $_POST['pago'];
$idAuto = $_POST['id_auto'];

// Insertar cliente
$idClientePersona = insertarPersona($clienteNombre, $db);
insertarCliente($idClientePersona, $db);

// Insertar vendedor
$idVendedorPersona = insertarPersona($vendedorNombre, $db);
insertarTrabajador($idVendedorPersona, $db);

// Insertar pago
$idPago = insertarPago($idClientePersona, $db);

// Insertar venta
$idPostVenta = null; // Por ahora no lo usamos
insertarVenta($idAuto, $idPostVenta, $idClientePersona, $idVendedorPersona, $idPago, $db);

// Actualizar disponibilidad del auto
pg_query_params($db, "UPDATE Auto SET Disponibilidad = false, Apartado = true WHERE ID_Auto = $1", [$idAuto]);

// Confirmación
echo "<h2>✅ Venta registrada exitosamente</h2>";
echo "<p><a href='index.php'>Volver al catálogo</a></p>";
?>
