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

    //funcion para ver todas las publicaciones
    public function verTodas()
    {
        $publicaciones = new publicacion();

        $todas = $publicaciones->getAll();

        require_once 'views/publicaciones/todas.php';
    }

    //se vera una sola publicacion
    public function verPublicacion()
    {
        
    }

    //funcion para solo ver las publicaciones de un usuario
    public function misPublicaciones()
    {
        //verificamos que el usuario este logeado
        if(utils::isIdentity()){
            //creamos un objeto del modelo publicacion
            $publicacion = new publicacion();

            //guardamos el id del usuario, que esta en la session
            $id = $_SESSION['usuario_identificado']->id_usuario;

            //llamamos el metodo publicacionesUsuario para que nos traiga todas las publicaciones de ese usuario
            $publicaciones = $publicacion->publicacionesUsuario($id);

            //mandar a la vista
            require_once 'views/publicaciones/mis-publicaciones.php';
        } else{
            header('Location:'.base_url);
        }
    }

    //funcion para mostrar el formulario de crear
    public function crear()
    {
        //comprobamos que el usuario este identificado

        //manda a la vista
        require_once 'views/publicaciones/crear.php';
    }

    //funcion para guardar una publicacion
    public function guardar()
    {

    }

    //funcion para editar una publicacion
    public function editar()
    {

    }
}