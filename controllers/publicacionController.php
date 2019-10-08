<?php
require_once 'models/publicacion.php';

class publicacionController{

    public function index(){
        //echo "Controlador publicaciones, action index";

        //renderizar las vistas
        require_once 'views/layout/registro-entrar.php';
        require_once 'views/layout/bienvenida.php';
        require_once 'views/publicaciones/destacadas.php';
    }
}