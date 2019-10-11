<?php

class categoria{
    private $id;
    private $nombre;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId(){
        return $this->id;
    }

    function getNombre(){
        return $this->nombre;
    }

    function setId($id){
        $this->id = $id;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    //metodo para obtener todas las categorias
    function getAll(){
        $categorias = $this->db->query("SELECT * FROM categoria ORDER BY id_categoria DESC;");
        return $categorias;
    }

    //metodo que obtiene una sola categoria
    function getOne(){
        $categoria = $this->db->query("SELECT * FROM categoria WHERE id_categoria={$this->getId()};");
        return $categoria->fetch_object();
    }

    //metodo para guardar una categoria
    function save(){
        $sql = "INSERT INTO categoria VALUES(null, '{$this->getNombre()}');";
        $save = $this->db->query($sql);

        $resultado = false;
        
        if($save)
            $resultado=true;

        return $resultado;
    }

}