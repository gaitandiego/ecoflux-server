<?php

namespace App\Classes;

// Clase para la sesion
class SessionManager
{
    public function __construct()
    {
        session_start();
    }

    public function newSession()
    {
        // Remove cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), false, -1, "/");
        }
        //clear session from disk
        $_SESSION = array();
        session_destroy();
        session_write_close();

        // new id
        session_id(session_create_id());

        // new session
        session_start();
    }

    public function getId()
    {
        return session_id();
    }

    public function getAll()
    {
        return $_SESSION;
    }

    public function clean()
    {
        return $_SESSION = [];
    }

    public function get($key)
    {
        if (empty($_SESSION[$key])) {
            return false;
        }

        return $_SESSION[$key];
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}
