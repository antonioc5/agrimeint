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

    function getDb(){
        return $this->db;
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
    function getAll()
    {
        $sql ="SELECT * FROM publicacion INNER JOIN usuario 
            ON usuario.id_usuario = publicacion.id_usuario 
            ORDER BY publicacion.id_publicacion DESC;";

        $publicaciones = $this->db->query($sql);

        return $publicaciones;
    }

    //funcion para obtener todas las publicaciones por categoria
    function getAllCategory(){

    }

    //funcion para obtener publicaciones aleatorias
    function getRandom($limit)
    {
        $sql ="SELECT * FROM publicacion INNER JOIN usuario 
            ON usuario.id_usuario = publicacion.id_usuario 
            ORDER BY RAND() LIMIT $limit;";

        $publicaciones = $this->db->query($sql);

        return $publicaciones;
    }

    //funcion para obtener una sola publicacion 
    function getOne()
    {
        $sql ="SELECT * FROM publicacion INNER JOIN usuario 
            ON usuario.id_usuario = publicacion.id_usuario 
            WHERE publicacion.id_publicacion = {$this->getId()};";

        $publicacion = $this->db->query($sql);

        return $publicacion;
    }

    //funcion para guardar una publicacion 
    function save()
    {
        $sql = "INSERT INTO publicacion VALUES (null, {$this->getIdUsuario()}, {$this->getIdCategoria()},'{$this->getImagen()}', '{$this->getTitulo()}', {$this->getPrecio()}, '{$this->getDescripcion()}', '{$this->getEstado()}', '{$this->getMunicipio()}', NOW());";
        $save = $this->db->query($sql);
        
        $resultado = false;

        if($save)
            $resultado = true;

        return $resultado;
    }

    //funcion para actualizar la publicacion
    function update()
    {
        $sql = "UPDATE publicacion SET id_categoria = {$this->idCategoria}, imagen = '{$this->imagen}', titulo = '{$this->titulo}', precio = {$this->precio}, descripcion = '{$this->descripcion}', estado = '{$this->estado}', municipio = '{$this->municipio}' WHERE id_publicacion = {$this->id};";
        $save = $this->db->query($sql);

        $resultado = false;

        if($save)
            $resultado = true;

        return $resultado;
    }

    //funcion para borrar la publicacion
    function delete()
    {
        $sql = "DELETE FROM publicacion WHERE id_publicacion = {$this->getId()};";
        $delete = $this->db->query($sql);

        $resultado = false;

        if($delete)
            $resultado = true;

        return $resultado;
    }

    //funcion para obtener las publicaciones de un usuario
    function publicacionesUsuario($id)
    {
        $sql ="SELECT * FROM publicacion INNER JOIN usuario 
            ON usuario.id_usuario = publicacion.id_usuario 
            WHERE publicacion.id_usuario = {$id} ORDER BY publicacion.id_publicacion";

        $publicaciones = $this->db->query($sql);

        return $publicaciones;
    }

    //funcion para buscar publicaciones
    function busquedaPublicaciones($titulo)
    {
        $sql = "SELECT * FROM publicacion INNER JOIN usuario 
            ON usuario.id_usuario = publicacion.id_usuario 
            WHERE publicacion.titulo LIKE '%{$titulo}%';";

        $publicacion = $this->db->query($sql);

        return $publicacion;
    }
}
