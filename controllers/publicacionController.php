<?php
require_once 'models/publicacion.php';

class publicacionController{

    public function index(){
        //echo "Controlador publicaciones, action index";

        //renderizar las vistas
        require_once 'views/usuarios/registro-entrar.php';
        require_once 'views/layout/bienvenida.php';
        require_once 'views/publicaciones/destacadas.php';
    }

    public function verTodas(){
        $publicaciones = new publicacion();

        $todas = $publicaciones->getAll();

        require_once 'views/publicaciones/todas.php';
    }

    public function verPublicacion(){
        //se vera una sola publicacion
    }
}