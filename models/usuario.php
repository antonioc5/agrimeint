<?php

class usuario
{
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

    function getDb()
    {
        return $this->db;
    }

    function getId()
    {
        return $this->id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getApellidos()
    {
        return $this->apellidos;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getTelefono()
    {
        return $this->telefono;
    }

    function getPassword()
    {
        return $this->password;
    }

    function getNivel()
    {
        return $this->nivel;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    //funcion pra guardar un usuario
    function save()
    {

        $sql = "INSERT INTO usuario VALUES (null, '{$this->nombre}', '{$this->apellidos}', '{$this->email}', '{$this->telefono}', '{$this->password}', null, CURDATE(), null);";
        $save = $this->db->query($sql);

        $resultado = false;

        if ($save)
            $resultado = true;

        return $resultado;
    }

    //funcion para autenticar al usuario
    function login()
    {
        //este metodo devolvera el arreglo login que tendra el resultado del login(true/false), los datos del usuario que entro y los errores posibles en el login
        $login = array(
            'resultado' => false
        );

        $email = $this->getEmail();
        $password = $this->getPassword();

        //comprobamos si el usuario existe 
        $sql = "SELECT * FROM usuario WHERE email = '$email';";
        $resultado = $this->db->query($sql);

        if ($resultado && $resultado->num_rows == 1) {
            $usuario = $resultado->fetch_object();

            //ahora validamos la contraseña
            $verify = password_verify($password, $usuario->password);

            if ($verify) {
                //guardamos todos los datos del usuario para regresarlo y poderlos tener en la session
                $this->id = $usuario->id_usuario;
                $this->nombre = $usuario->nombre;
                $this->apellidos = $usuario->apellidos;
                $this->email = $usuario->email;
                $this->telefono = $usuario->telefono;

                $login['resultado'] = true;
                $login['usuario'] = $usuario;
            } else {
                $login['resultado'] = false;
                $login['error']= "¡La contraseña no es correcta!";
            }
        } else {
            //el usuario no existe en la bd
            $login['error'] = '¡No existe ninguna cuenta registrada con este correo!';
        }

        return $login;
    }

    //funcion para obtener un usuario
    public function getUsuario(){
        $usuario = false;

        $sql = "SELECT * FROM usuario WHERE id_usuario = {$this->id};";
        $resultado = $this->db->query($sql);

        if($resultado && $resultado->num_rows==1){
            $usuario = $resultado->fetch_object();
        }

        return $usuario;
    }

    //funcion para modificar o actualizar un usuario
    public function modificar(){
        $actualizado = false;

        $sql = "UPDATE usuario SET nombre = '{$this->nombre}', apellidos = '{$this->apellidos}', telefono = '{$this->telefono}' WHERE id_usuario = {$this->id};";
        $resultado = $this->db->query($sql);

        if($resultado){
            $actualizado = true;
        }

        return $actualizado;
    }

}
