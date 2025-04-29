<?php
// Iniciar sesión ANTES de cualquier salida HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- AJUSTAR RUTAS REQUIRE_ONCE ---
require_once __DIR__ . '/../config/Database.php'; // Sube a agenciaPIS2, entra a config
require_once __DIR__ . '/../app/vista/IInventario.php'; // Sube a agenciaPIS2, entra a app/vista
require_once __DIR__ . '/../app/servicios/InventarioReal.php'; // Sube a agenciaPIS2, entra a app/servicios
require_once __DIR__ . '/../app/servicios/ProxyInventario.php'; // Sube a agenciaPIS2, entra a app/servicios

// --- AÑADIR 'use' PARA CLASES GLOBALES ---
// use PDOException; // Para el try-catch de la conexión

// --- Configuración (sin cambios) ---
$usuarios = ['admin' => '123', 'user' => '456'];
$db = null;
$proxy = null;
$error_login = '';
$mensaje_accion = '';

// --- Conexión a BD (sin cambios, usa el Database.php de config) ---
try {
    $db = \Database::getConnection();
    $db->exec("SET search_path TO app;");

} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// --- Lógica de Login (sin cambios) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (isset($usuarios[$user]) && $usuarios[$user] === $pass) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        $_SESSION['isAdmin'] = ($user === 'admin');
        // Redirigir para evitar reenvío de formulario
        header("Location: index.php?route=inventario");
        exit;
    } else {
        $error_login = "Usuario o contraseña incorrectos.";
    }
}

// --- Lógica de Logout (sin cambios en la lógica, solo en la redirección si es necesario más adelante) ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php?route=inventario"); // Por ahora, redirige a sí mismo
    exit;
}

// --- Verificar si el usuario está logueado (sin cambios) ---
$loggedIn = $_SESSION['loggedin'] ?? false;
$isAdmin = $_SESSION['isAdmin'] ?? false;

// --- Instanciar Proxy si está logueado ---
if ($loggedIn) {
    $inventarioReal = new \app\servicios\InventarioReal($db);
    $proxy = new \app\servicios\ProxyInventario($inventarioReal, $isAdmin);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $redirectAction = 'view'; // Acción por defecto para redirigir
        try {
            switch ($_POST['action']) {
                case 'register':
                    if ($isAdmin && !empty($_POST['modelo'])) {
                        $proxy->agregarAuto(trim($_POST['modelo'])); // Llamada al proxy sin cambios
                    } elseif (!$isAdmin) {
                        $mensaje_accion = "Acción no permitida.";
                    } else {
                         $mensaje_accion = "El modelo no puede estar vacío.";
                    }
                    // Redirigir a la vista principal después de la acción POST
                    header("Location: index.php?route=inventario&action=" . $redirectAction); // Redirige a sí mismo
                    exit;
                case 'update':
                     if ($isAdmin && isset($_POST['id_auto']) && !empty($_POST['modelo'])) {
                        $proxy->actualizarAuto(intval($_POST['id_auto']), trim($_POST['modelo'])); // Llamada al proxy sin cambios
                    } elseif (!$isAdmin) {
                         $mensaje_accion = "Acción no permitida.";
                    } else {
                         $mensaje_accion = "Datos incompletos para actualizar.";
                    }
                     // Redirigir a la vista principal después de la acción POST
                    header("Location: index.php?route=inventario&action=" . $redirectAction); // Redirige a sí mismo
                    exit;
            }
        } catch (\RuntimeException | \Exception $e) { // Capturar excepciones lanzadas por el proxy/servicio
            $errorParam = urlencode("Error: " . $e->getMessage());
            header("Location: index.php?route=inventario&action=" . $redirectAction . "&error=" . $errorParam); // Apunta a index.php
            exit;
        }
    }
}

$viewAction = $_GET['action'] ?? ($loggedIn ? 'view' : 'login');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Autos - Inventario</title>
    <link rel="stylesheet" href="styles/inventario.css">
</head>
<body>
    <div class="container">
        <h1>Inventario Agencia de Autos</h1>

        <?php if ($loggedIn): ?>
            <nav>
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span><br><br>
                <a href="index.php?route=inventario&action=view">Ver Inventario</a>
                <?php if ($isAdmin): ?>
                    <a href="index.php?route=inventario&action=show_register">Registrar Auto</a>
                    <a href="index.php?route=inventario&action=show_update">Actualizar Auto</a>
                <?php endif; ?>
                <a href="index.php?route=inventario&action=logout" class="logout-btn">Salir</a>
            </nav>

             <?php if (!empty($mensaje_accion)): ?>
                <p class="mensaje"><?php echo htmlspecialchars($mensaje_accion); ?></p>
            <?php endif; ?>
             <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></p>
            <?php endif; ?>


            <?php // --- VISTAS PARA USUARIOS LOGUEADOS --- ?>
            <?php if ($proxy && $viewAction === 'view'): ?>
                <h2>Autos en Inventario</h2>
                <?php
                    $autos = $proxy->listarAutos();
                    if (count($autos) > 0):
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Modelo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($autos as $auto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($auto['id_auto']); ?></td>
                                <td><?php echo htmlspecialchars($auto['modelo']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay autos registrados en el inventario.</p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($isAdmin && $proxy && $viewAction === 'show_register'): ?>
                <h2>Registrar Nuevo Auto</h2>
                <form action="index.php?route=inventario" method="POST">
                    <input type="hidden" name="action" value="register">
                    <label for="modelo">Modelo del Auto:</label>
                    <input type="text" id="modelo" name="modelo" required>
                    <button type="submit">Registrar</button>
                </form>
            <?php endif; ?>

            <?php if ($isAdmin && $proxy && $viewAction === 'show_update'): ?>
                <h2>Actualizar Auto Existente</h2>
                 <?php $autos = $proxy->listarAutos(); ?>
                 <?php if (count($autos) > 0): ?>
                    <form action="index.php?route=inventario" method="POST">
                        <input type="hidden" name="action" value="update">
                        <label for="id_auto">ID del Auto a Modificar:</label>
                        <select name="id_auto" id="id_auto" required>
                             <option value="">-- Seleccione ID --</option>
                             <?php foreach ($autos as $auto): ?>
                                <option value="<?php echo htmlspecialchars($auto['id_auto']); ?>">
                                    <?php echo htmlspecialchars($auto['id_auto']) . " - " . htmlspecialchars($auto['modelo']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <label for="modelo">Nuevo Modelo:</label>
                        <input type="text" id="modelo" name="modelo" required>
                        <button type="submit">Actualizar</button>
                    </form>
                 <?php else: ?>
                    <p>No hay autos para actualizar.</p>
                 <?php endif; ?>
            <?php endif; ?>


        <?php else: // --- VISTA DE LOGIN --- ?>
            <h2>Iniciar Sesión</h2>
            <?php if ($error_login): ?>
                <p class="error"><?php echo $error_login; ?></p>
            <?php endif; ?>
            <form action="index.php?route=inventario" method="POST">
                <input type="hidden" name="action" value="login">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
            <p>Usuarios de prueba: admin (pass: 123), user (pass: 456)</p>
            <a href="index.php">⬅️ Volver al catálogo</a>
        <?php endif; ?>

    </div>
</body>
</html>