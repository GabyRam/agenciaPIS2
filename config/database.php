<?php
class Database {   // ESTA CLASE ES PARA EL PATRON PROXY
    private static $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            // Carga la configuración desde config.php en el mismo directorio
            $config = require __DIR__ . '/config.php';
            $dsn = "pgsql:host={$config['host']};dbname={$config['dbname']}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$pdo = new PDO($dsn, $config['user'], $config['password'], $options);
                // Establecer el search_path para usar el esquema 'app' por defecto
                self::$pdo->exec("SET search_path TO app");
            } catch (PDOException $e) {
                // En una aplicación real, manejarías esto de forma más robusta (log, mensaje amigable)
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$pdo;
    }
}
?>