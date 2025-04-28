<?php
namespace app\controlador;

use app\modelo\Venta;
use app\modelo\Venta_Cliente;
use app\modelo\Venta_Vendedor;
use app\modelo\Venta_Pago;

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
