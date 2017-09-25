<?php

namespace App\Lib;

use PDO;

class Database {
    public static function StartUp() {
        $servidor = 'localhost';
        $base_datos = 'cnokonec_movil_prueba';
        $usuario = 'cnokonec_movil';
        $clave = 'cnokonec_movil';

        $sql_conn = 'mysql:host=' . $servidor . ';dbname=' . $base_datos . ';charset=utf8';
        $pdo = new PDO($sql_conn, $usuario, $clave);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $pdo;
    }
}
