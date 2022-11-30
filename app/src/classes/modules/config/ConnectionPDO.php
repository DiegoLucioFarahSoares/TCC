<?php

namespace app\src\classes\modules\config;

use Exception;
use PDO;

class ConnectionPDO
{

    protected static $db;

    private function __construct()
    {
        $config = require __DIR__ . '/configBd.php';

        $host =     $config['dbHost'];
        $dbName =   $config['dbName'];
        $user =     $config['dbUser'];
        $pass =     $config['dbPass'];

        try {
            self::$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $pass);

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function getConnection() {

        if (!self::$db) {
            new ConnectionPdo();
        }

        return self::$db;
    }
}