<?php

namespace App\Services;
//Conexion a modelo de db
use App\Models\AccesoDatos;
use \PDO;

class EstadosService
{
    private $db;

    public function __construct(AccesoDatos $db)
    {
        $this->db = $db;
    }

    //funcion utilizada en controllers getEmpresasController
    public function get()
    {
        try {

            $sql = "SELECT *  from estados";
            //Conexion a la db

            $stmt = $this->db->prepararConsulta($sql);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);


            return $datos;
        } catch (
            \PDOException  $th
        ) {
            throw new \Exception($th->getMessage());
        }
    }


    //funcion utilizada en controllers posEmpresasController
    public function post($nombre, $color, $tipo)
    {
        try {
            $sql = "INSERT INTO estados (nombre,color,tipo) VALUES (:nombre, :color, :tipo)";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->execute();

            return true;
        } catch (\PDOException  $th) {
            throw new \Exception($th->getMessage());
        }
    }

    //funcion utilizada en controllers putEmpresasController
    public function put($id, $nombre, $color, $tipo)
    {
        try {
            $sql = "UPDATE estados SET nombre = :nombre,color = :color,tipo = :tipo WHERE id = :id";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        } catch (
            \PDOException  $th
        ) {
            throw new \Exception($th->getMessage());
        }
    }

    //funcion utilizada en controllers deleteEmpresasController
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM estados WHERE id = :id";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (
            \PDOException  $th
        ) {
            throw new \Exception($th->getMessage());
        }
    }
}
