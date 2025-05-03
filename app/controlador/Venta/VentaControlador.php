<?php
namespace app\controlador\Venta;

use app\modelo\Venta\Venta;
use app\modelo\Venta\Venta_Cliente;
use app\modelo\Venta\Venta_Vendedor;
use app\modelo\Venta\Venta_Pago;

class VentaControlador {
    public function realizarVenta() {
        $ventaBase = new Venta();

        // Decoramos la venta
        $ventaConCliente = new Venta_Cliente($ventaBase);
        $ventaConVendedor = new Venta_Vendedor($ventaConCliente);
        $ventaFinal = new Venta_Pago($ventaConVendedor);

        // Procesamos la venta completa
        $ventaFinal->procesarVenta();
    }
}
?>
