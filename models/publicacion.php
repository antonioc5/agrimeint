<?php

class publicacion
{
    private $id;
    private $idUsuario;
    private $idCategoria;
    private $imagen;
    private $titulo;
    private $precio;
    private $descripcion;
    private $estado;
    private $municipio;
    private $fechaPublicacion;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    function getId(){
        return $this->id;
    }

    function getIdUsuario(){
        return $this->idUsuario;
    }

    function getIdCategoria(){
        return $this->idCategoria;
    }

    function getImagen(){
        return $this->imagen;
    }

    function getTitulo(){
        return $this->titulo;
    }

    function getPrecio(){
        return $this->precio;
    }

    function getDescripcion(){
        return $this->descripcion;
    }

    function getEstado(){
        return $this->estado;
    }

    function getMunicipio(){
        return $this->municipio;
    }

    function getFechaPublicacion(){
        return $this->fechaPublicacion;
    }

    function setId($id){
        $this->id = $id;
    }

    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    function setIdCategoria($idCategoria){
        $this->idCategoria = $idCategoria;
    }

    function setImagen($imagen){
        $this->imagen = $imagen;
    }

    function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    function setPrecio($precio){
        $this->precio = $precio;
    }

    function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    function setEstado($estado){
        $this->estado = $estado;
    }

    function setMunicipio($municipio){
        $this->municipio = $municipio;
    }

    function setFechaPublicacion($fechaPublicacion){
        $this->fechaPublicacion = $fechaPublicacion;
    }

    //funcion para obtener todas las publicaciones 
    function getAll(){
        $publicaciones = $this->db->query("SELECT * FROM publicacion ORDER BY id_publicacion DESC;");

        return $publicaciones;
    }

    //funcion para obtener todas las publicaciones por categoria
    function getAllCategory(){

    }

    //funcion para obtener publicaciones aleatorias
    function getRandom($limit){
        $publicaciones = $this->db->query("SELECT * FROM publicacion ORDER BY RAND() LIMIT $limit;");

        return $publicaciones;
    }

    //funcion para obtener una sola publicacion 
    function getOne(){
        $publicacion = $this->db->query("SELECT * FROM publicacion WHERE id_publicacion = {$this->getId()};");
        
        return $publicacion->fetch_object();
    }

    //funcion para guardar una publicacion 
    function save(){
        $sql = "INSERT INTO publicacion VALUES (null, {$this->getIdUsuario()}, {$this->getIdCategoria()},'{$this->getImagen()}', '{$this->getTitulo()}', {$this->getPrecio()}), '{$this->getDescripcion()}', '{$this->getEstado()}', '{$this->getMunicipio()}', CURDATE();";
        $save = $this->db->query($sql);

        $resultado = false;

        if(save)
            $resultado = true;

        return $resultado;
    }

    //funcion para editar la publicacion
    function edit(){

    }

    //funcion para borrar la publicacion
    function delete(){
        $sql = "DELETE FROM publicacion WHERE id_publicacion = {$this->getId()};";
        $delete = $this->db->query($sql);

        $resultado = false;

        if($delete)
            $resultado = true;

        return $resultado;
    }
}
