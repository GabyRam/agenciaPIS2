<?php
require_once __DIR__ . '/../app/servicios/database.php';

use app\servicios\database;

$db = database::getConnection(); // esto probará la conexión

echo "🚀 Conexión exitosa!";
