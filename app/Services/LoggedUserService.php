<?php

namespace App\Services;

use App\Classes\SessionManager;
use App\Models\AccesoDatos;
use \PDO;

class LoggedUserService
{
    const SESSION_USER_DATA_KEY = 'user_data';

    private $userData;
    private $session;
    private $db;

    public function __construct(SessionManager $session, AccesoDatos $db)
    {
        $this->session = $session;
        $this->userData = $this->session->get(self::SESSION_USER_DATA_KEY);
        $this->db = $db;
    }

    public function login($email, $password)
    {
        try {
            $sql = 'SELECT u.id,u.activo,u.email,u.password,u.nombre_usuario,u.fecha,r.nombre as rol FROM usuarios u JOIN roles r on r.id = u.id_rol WHERE email  = :email AND password = :password';
            $this->db->obtenerInstancia();
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', md5($password), PDO::PARAM_STR);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$datos || $datos['activo'] == 'false') {
                throw new \Exception('Error on login', 504);
            }

            $this->userData = $datos;
            $this->saveData();

            $sqlData = 'SELECT p.nombre FROM usuarios u JOIN  roles r on r.id = u.id_rol JOIN  roles_permisos rp on rp.id_rol = r.id JOIN permisos p on p.id = rp.id_permisos WHERE email  = :email';
            $this->db->obtenerInstancia();
            $stmt = $this->db->prepararConsulta($sqlData);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $datosPermisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $datosPem = [];
            foreach ($datosPermisos as $key => $value) {
                array_push($datosPem, $value['nombre']);
            }

            $datos['permisos'] = $datosPem;
            return $datos;
        } catch (
            \PDOException  $th
        ) {
            throw new \Exception($th->getMessage());
        }
    }


    public function getDataUser($email)
    {
        try {
            $sql = 'SELECT u.id,u.activo,u.email,u.password,u.nombre_usuario,u.fecha,r.nombre as rol FROM usuarios u JOIN roles r on r.id = u.id_rol WHERE email  = :email';
            $this->db->obtenerInstancia();
            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$datos || $datos['activo'] == 'false') {
                throw new \Exception('Error on login', 504);
            }

            $this->userData = $datos;
            $this->saveData();

            $sqlData = 'SELECT p.nombre FROM usuarios u JOIN  roles r on r.id = u.id_rol JOIN  roles_permisos rp on rp.id_rol = r.id JOIN permisos p on p.id = rp.id_permisos WHERE email  = :email';
            $this->db->obtenerInstancia();
            $stmt = $this->db->prepararConsulta($sqlData);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $datosPermisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $datosPem = [];
            foreach ($datosPermisos as $key => $value) {
                array_push($datosPem, $value['nombre']);
            }

            $datos['permisos'] = $datosPem;

            return $datos;
        } catch (\PDOException  $th) {
            throw new \Exception($th->getMessage());
        }
    }
    public function getId()
    {
        return $this->userData ? $this->userData['id'] : false;
    }

    public function isLogged()
    {
        return !empty($this->userData['id']);
    }

    public function getName()
    {
        return $this->userData['nombre_usuario'];
    }
    public function logout()
    {
        $this->session->newSession();
    }

    private function saveData()
    {
        $this->session->set(self::SESSION_USER_DATA_KEY, $this->userData);
    }
}
