<?php

namespace App\Services;
//Conexion a modelo de db
use App\Models\AccesoDatos;
use \PDO;

class UsuariosService
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

            $sql = "SELECT *  from Usuarios";
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
            $sql = "INSERT INTO Usuarios (email,password,nombre_usuario,empresa,rol) VALUES (:email, :password, :nombre_usuario, :empresa, :rol)";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':email', $params['email']);
            $stmt->bindParam(':password', md5($params['password']));
            $stmt->bindParam(':nombre_usuario', $params['nombre_usuario']);
            $stmt->bindParam(':empresa', $params['empresa']);
            $stmt->bindParam(':rol', $params['rol']);
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
            $sql = "UPDATE Usuarios SET nombre_usuario = :nombre_usuario, password = :password, email = :email,empresa = :empresa, rol = :rol WHERE id = :id";
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindParam(':id', $params['id']);
            $stmt->bindParam(':nombre_usuario', $params['nombre_usuario']);
            $stmt->bindParam(':password', md5($params['password']));
            $stmt->bindParam(':email', $params['email']);
            $stmt->bindParam(':empresa', $params['empresa']);
            $stmt->bindParam(':rol', $params['rol']);
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
            $sql = "DELETE FROM Usuarios WHERE id = :id";
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
