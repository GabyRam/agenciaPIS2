<?php
namespace app\controlador;

use Exception;
use PDO;
use app\servicios\Database;

class FacturaController
{
    public function generarFactura($idPago, $clienteNombre, $clienteRFC, $fecha, $monto, $tipoFactura)
    {
        $db = Database::getConnection();

        $query = "INSERT INTO facturas (id_pago, cliente_nombre, cliente_rfc, fecha, monto, tipo_factura)
                  VALUES (:id_pago, :cliente_nombre, :cliente_rfc, :fecha, :monto, :tipo_factura)";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':id_pago', $idPago);
        $stmt->bindParam(':cliente_nombre', $clienteNombre);
        $stmt->bindParam(':cliente_rfc', $clienteRFC);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':tipo_factura', $tipoFactura);

        if ($stmt->execute()) {
            return "✅ Factura generada exitosamente.";
        } else {
            throw new Exception("❌ No se pudo generar la factura.");
        }
    }
}
