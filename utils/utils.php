<?php
//En esta clase encontraremos metodos que usaremos muchas veces en diversas partes de las acciones de los controladores

require_once 'models/categoria.php';

class utils
{
    //funcion para borrar una session
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }
    
    //funcion para comprobar que el usuario este identificado o logueado
    public static function isIdentity(){
        $identity = false;

        if(isset($_SESSION['usuario_identificado'])){
            $identity = true;
        }

        return $identity;
    }

    //funcion para mostrar todas las categorias
    public static function getAllCategorias(){
        //creo un objeto del modelo categorias
        $categoria = new categoria();

        //llamo el metodo getAll para obtener todas las categorias
        $categorias = $categoria->getAll();

        //regreso todas las categorias en un objeto
        return $categorias;
    }
}
