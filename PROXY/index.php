<?php
// Iniciar sesión ANTES de cualquier salida HTML
session_start();

// Incluir dependencias
require_once __DIR__ . '/../config/Database.php'; // Ruta actualizada
require_once __DIR__ . '/IInventario.php';
require_once __DIR__ . '/InventarioReal.php';
require_once __DIR__ . '/ProxyInventario.php';
// Las clases UI ya no se usarán de la misma forma, las reemplazaremos por HTML directo aquí

// --- Configuración ---
$usuarios = ['admin' => '123', 'user' => '456']; // Mantener por ahora, idealmente iría a BD
$db = null;
$proxy = null;
$error_login = '';
$mensaje_accion = ''; // Para mostrar mensajes como "Auto agregado"

// --- Conexión a BD ---
try {
    $db = Database::getConnection();
} catch (PDOException $e) {
    // Mostrar error crítico y detener ejecución si no hay BD
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// --- Lógica de Login ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (isset($usuarios[$user]) && $usuarios[$user] === $pass) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        $_SESSION['isAdmin'] = ($user === 'admin');
        // Redirigir para evitar reenvío de formulario
        header("Location: index.php");
        exit;
    } else {
        $error_login = "Usuario o contraseña incorrectos.";
    }
}

// --- Lógica de Logout ---
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// --- Verificar si el usuario está logueado ---
$loggedIn = $_SESSION['loggedin'] ?? false;
$isAdmin = $_SESSION['isAdmin'] ?? false;

// --- Instanciar Proxy si está logueado ---
if ($loggedIn) {
    $inventarioReal = new InventarioReal($db);
    // Pasamos el rol desde la sesión
    $proxy = new ProxyInventario($inventarioReal, $isAdmin);

    // --- Manejo de Acciones (POST para modificaciones) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'register':
                    if ($isAdmin && !empty($_POST['modelo'])) {
                        // La salida del mensaje ahora la hace el método
                        $proxy->agregarAuto(trim($_POST['modelo']));
                    } elseif (!$isAdmin) {
                        $mensaje_accion = "Acción no permitida.";
                    } else {
                         $mensaje_accion = "El modelo no puede estar vacío.";
                    }
                    // Redirigir a la vista principal después de la acción POST
                    header("Location: index.php?action=view");
                    exit;
                case 'update':
                    if ($isAdmin && isset($_POST['id']) && !empty($_POST['modelo'])) {
                        // La salida del mensaje ahora la hace el método
                        $proxy->actualizarAuto(intval($_POST['id']), trim($_POST['modelo']));
                    } elseif (!$isAdmin) {
                         $mensaje_accion = "Acción no permitida.";
                    } else {
                         $mensaje_accion = "ID y modelo son requeridos para actualizar.";
                    }
                     // Redirigir a la vista principal después de la acción POST
                    header("Location: index.php?action=view");
                    exit;
            }
        } catch (Exception $e) {
            // Captura errores generales o de BD durante las acciones
            $mensaje_accion = "Error al procesar la acción: " . $e->getMessage();
            // Considera redirigir o mostrar el error de forma diferente
             header("Location: index.php?action=view&error=" . urlencode($mensaje_accion));
             exit;
        }
    }
}

// --- Determinar qué vista mostrar (GET) ---
$viewAction = $_GET['action'] ?? ($loggedIn ? 'view' : 'login'); // Vista por defecto: login si no logueado, view si logueado

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Autos - Inventario</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        nav { background-color: #f2f2f2; padding: 10px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 800px; margin: auto; }
        .error { color: red; }
        .mensaje { color: green; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9;}
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], input[type="number"] { width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; }
        button { padding: 10px 15px; background-color: #5cb85c; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #4cae4c; }
        .logout-btn { background-color: #d9534f; float: right;}
        .logout-btn:hover { background-color: #c9302c; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventario Agencia de Autos</h1>

        <?php if ($loggedIn): ?>
            <nav>
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="index.php?action=view">Ver Inventario</a>
                <?php if ($isAdmin): ?>
                    <a href="index.php?action=show_register">Registrar Auto</a>
                    <a href="index.php?action=show_update">Actualizar Auto</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="logout-btn">Salir</a>
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
                                <td><?php echo htmlspecialchars($auto['id']); ?></td>
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
                <form action="index.php" method="POST">
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
                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="update">
                        <label for="id">ID del Auto a Modificar:</label>
                        <select name="id" id="id" required>
                             <option value="">-- Seleccione ID --</option>
                             <?php foreach ($autos as $auto): ?>
                                <option value="<?php echo htmlspecialchars($auto['id']); ?>">
                                    <?php echo htmlspecialchars($auto['id']) . " - " . htmlspecialchars($auto['modelo']); ?>
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
            <form action="index.php" method="POST">
                <input type="hidden" name="action" value="login">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
            <p>Usuarios de prueba: admin (pass: 123), user (pass: 456)</p>
        <?php endif; ?>

    </div>
</body>
</html>