<?php

class usuario{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $telefono;
    private $password;
    private $nivel;
    private $fechaRegistro;
    private $foto;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->nivel = null;
    }

    function getDb(){
        return $this->db;
    }

    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre;
    }

    function getApellidos(){
        return $this->apellidos;
    }

    function getEmail(){
        return $this->email;
    }

    function getTelefono(){
        return $this->telefono;
    }

    function getPassword(){
        return $this->password;
    }

    function getNivel(){
        return $this->nivel;
    }

    function setId($id){
        $this->id = $id;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    function setPassword($password){
        $this->password = $password;
    }

    function setNivel($nivel){
        $this->nivel = $nivel;
    }

    //funcion pra guardar un usuario
    function save(){
        $sql = "INSERT INTO usuario VALUES (null, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getTelefono()}', '{$this->getPassword()}', null, CURDATE(), null);";
        $save = $this->db->query($sql);

        $resultado = false;

        if($save)
            $resultado = true;

        return $resultado;
    }

    //funcion para autenticar al usuario
    function login(){
        $resultado = false;
        $email = $this->getEmail();
        $password = $this->getPassword();

        //comprobamos si el usuario existe 
        $sql = "SELECT * FROM usuario WHERE email = '$email';";
        $login = $this->db->query($sql);

        if($login && $login->num_rows == 1){
            $usuario = $login->fetch_object();

            //ahora validamos la contraseña
            $verify = password_verify($password, $usuario->password);

            if($verify)
                $resultado = $usuario;
        }

        return $resultado;
    }


}