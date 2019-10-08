<?php
require_once 'models/usuario.php';

class usuarioController{

    public function index(){
        echo "Controlador usuarios, accion index";
    }

    public function registro(){
        //echo "Controlador usuarios, accion registro, esta pagina nos llevara al registro";
        echo "<h3 class='fw-300 centrar-texto'>Inicia sesion o crea una cuenta</h3>";
        
        require_once 'views/usuarios/registro-entrar.php';
    }

}