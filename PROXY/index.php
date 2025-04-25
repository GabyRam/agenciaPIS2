<?php
include("IInventario.php");
include("InventarioReal.php");
include("ProxyInventario.php");
include("UI_ActualizacionExistencias.php");
include("UI_RegistroVehicular.php");
include("UI_VisualizacionVehicular.php");
include("FuncionesInventario.php");

// Simulación de BD
$inventarioAutos = [];
$usuarios = ['admin' => '123', 'user' => '456'];

// Login
function login(array $usuarios): ?bool {
    echo "Usuario: ";
    $user = trim(fgets(STDIN));
    echo "Contraseña: ";
    $pass = trim(fgets(STDIN));
    return isset($usuarios[$user]) && $usuarios[$user] === $pass ? $user === 'admin' : null;
}
  
// Configuración inicial
$esAdmin = login($usuarios);
if ($esAdmin !== null) {
    $inventarioReal = new InventarioReal($inventarioAutos);
    $proxy = new ProxyInventario($inventarioReal, $esAdmin); 

    if ($esAdmin) {
        // --- MENÚ PARA ADMIN ---
        while (true) {
            echo "\n--- MENÚ ADMIN ---\n";
            echo "1. Registrar auto\n";
            echo "2. Actualizar auto\n";
            echo "3. Ver inventario\n";
            echo "4. Salir\n";
            echo "Opción: ";
            $opcion = trim(fgets(STDIN));
            switch ($opcion) {
                case '1': UI_RegistroVehicular::mostrar($proxy); break;
                case '2': UI_ActualizacionExistencias::mostrar($proxy); break;
                case '3': UI_VisualizacionVehicular::mostrar($proxy); break;
                case '4': exit();
                default: echo "Opción inválida.\n";
            }
        }
    } else {
        // --- MENÚ PARA USUARIO NORMAL ---
        while (true) {
            echo "\n--- MENÚ USUARIO ---\n";
            echo "1. Ver inventario\n";
            echo "2. Salir\n";
            echo "Opción: ";
            $opcion = trim(fgets(STDIN));
            switch ($opcion) {
                case '1': UI_VisualizacionVehicular::mostrar($proxy); break;
                case '2': exit();
                default: echo "Opción inválida.\n";
            }
        }
    }
} else {
    echo "Acceso denegado.\n";
}
?>

//IMPORTANTE
//Las contraseñas de los usuarios son:
// admin: 123
// user: 456
// El usuario admin tiene acceso a todas las funciones, mientras que el usuario normal solo puede ver el inventario.