<?php
//En esta clase encontraremos metodos que usaremos muchas veces en diversas partes de las acciones de los controladores

class utils
{

    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }
    
}
