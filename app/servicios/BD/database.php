<?php
namespace app\servicios\BD;

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../../config/config.php';
            $connString = "host={$config['host']} dbname={$config['dbname']} user={$config['user']} password={$config['password']}";
            self::$connection = pg_connect($connString);

            if (!self::$connection) {
                die("❌ Error de conexión: " . pg_last_error());
            }
        }

        return self::$connection;
    }
}
