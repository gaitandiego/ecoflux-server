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
            $sql = 'SELECT * FROM usuarios WHERE email  = :email AND password = :password';

            $stmt = $this->db->prepararConsulta($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', md5($password), PDO::PARAM_STR);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$datos) {
                throw new \Exception('Error on login', 504);
            }

            $this->userData = $datos;
            $this->saveData();

            return $datos;
        } catch (
            \PDOException  $th
        ) {
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
