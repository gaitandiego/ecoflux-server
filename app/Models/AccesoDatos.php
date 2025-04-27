<?php

namespace App\Models;

use \PDO;
use \mysqli;

class AccesoDatos
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $db_port;

    private static $objAccesoDatos;
    private $objetoPDO;

    public function __construct()
    {
        try {
            $this->host = "3.131.89.97";
            $this->user = "prospera";
            $this->pass = "ffe13650616411e8c990242ac120002";
            $this->db_port = "3306";
            $this->dbname = "ramos";

            $conn_str = "mysql:host=$this->host;port=$this->db_port;dbname=$this->dbname";
            $this->objetoPDO = new PDO($conn_str, $this->user, $this->pass);
            $this->objetoPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->objetoPDO->exec("SET CHARACTER SET utf8");
        } catch (\Throwable $th) {
            throw new \Exception('Error on db', 504);
        }
    }

    public static function obtenerInstancia()
    {
        if (!isset(self::$objAccesoDatos)) {
            self::$objAccesoDatos = new AccesoDatos();
        }
        return self::$objAccesoDatos;
    }

    public function prepararConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }


    public function __clone()
    {
        trigger_error('ERROR: La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
