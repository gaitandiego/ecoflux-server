<?php

namespace App\Services;
//Conexion a modelo de db
use App\Models\AccesoDatos;
use \PDO;

class RecoleccionesService
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

            $sql = "SELECT recolecciones.*,usuarios.nombre_usuario as nombre_usuario, usuarios.email as email,usuarios.empresa as empresa from recolecciones join usuarios on recolecciones.id_usuario = usuarios.id";
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
    public function post($params)
    {
        try {
            $sql = "INSERT INTO recolecciones (id_usuario,celular,direccion,ruta) VALUES (:id_usuario,:celular,:direccion,:ruta)";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':id_usuario', $params['id_usuario']);
            $stmt->bindParam(':celular', $params['celular']);
            $stmt->bindParam(':direccion', $params['direccion']);
            $stmt->bindParam(':ruta', $params['ruta']);

            $stmt->execute();

            return true;
        } catch (\PDOException  $th) {
            throw new \Exception($th->getMessage());
        }
    }

    //funcion utilizada en controllers putEmpresasController
    public function put($params)
    {
        try {
            $sql = "UPDATE recolecciones SET id_usuario = :id_usuario, ruta = :ruta, celular = :celular, direccion = :direccion WHERE id = :id";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':id', $params['id']);
            $stmt->bindParam(':id_usuario', $params['id_usuario']);
            $stmt->bindParam(':ruta', $params['ruta']);
            $stmt->bindParam(':celular', $params['celular']);
            $stmt->bindParam(':direccion', $params['direccion']);
            $stmt->execute();
            //verifica si se actualizo
            if ($stmt->rowCount() == 0) {
                throw new \Exception('No se actualizo el registro', 504);
            }
            //verifica si se actualizo
            if ($stmt->rowCount() == 0) {
                throw new \Exception('No se actualizo el registro', 504);
            }
            //verifica si se actualizo      
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
            $sql = "DELETE FROM recolecciones WHERE id = :id";
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
