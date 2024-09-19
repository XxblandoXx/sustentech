<?php


class Database {

    private static $host = 'localhost';
    private static $name = 'sustentech';
    private static $user = 'admin';
    private static $pass = 'root@861035!';

    private static $conn = null;

    private static function Connect() {

        try {

            if(self::$conn == null) {
                $option = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ];
                $dns = 'mysql:host='.self::$host.';dbname='.self::$name;
                self::$conn = new PDO($dns, self::$user, self::$pass, $option);

            }

        } catch(PDOException $ex) {

            echo "Erro! Conexão com o banco não estabelecida. (Erro gerado {$ex->getMessage()})";

        }

        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$conn;

    }

    public static function getConn() {
        return self::Connect();
    }

}