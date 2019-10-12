<?php
require_once 'models/publicacion.php';

class publicacionController{

    public function index()
    {
        //echo "Controlador publicaciones, action index";

        //renderizar las vistas
        require_once 'views/usuarios/registro-entrar.php';
        require_once 'views/layout/bienvenida.php';
        $this->verDestacadas();
    }

    //funcion para ver todas las publicaciones
    public function verTodas()
    {
        $publicacion = new publicacion();

        $publicaciones = $publicacion->getAll();

        require_once 'views/publicaciones/todas.php';
    }

    public function verDestacadas()
    {
        $publicacion = new publicacion();

        $publicaciones = $publicacion->getRandom(9);
        
        require_once 'views/publicaciones/destacadas.php';
    }

    //funcion para ver solo una publicacion
    public function verPublicacion()
    {
        //comprobamos que el usuario este identificado
        if(utils::isIdentity()){
            //comprobamos que nos llegue el id por get
            if(isset($_GET['id']) && !empty($_GET['id'])){
                // die(var_dump($_GET));
                $id = $_GET['id'];

                //creamos un objeto del modelo publicacion y llamamos al metodo getOne para obtener la publicacion con ese id
                $objPublicacion = new publicacion();
                $objPublicacion->setId($id);

                $publicacion = $objPublicacion->getOne();

                //comprobamos que la publicacion si exista
                if($publicacion->num_rows != 0){
                    //mandamos a la vista ver-publicacion
                    $publicacion = $publicacion->fetch_object();
                    require_once 'views/publicaciones/ver-publicacion.php';
                } else{
                    echo "<div class='mensaje error'>No existe esa publicacion!</div>";
                    header("Refresh:5; url=".base_url);
                }
            } else{
                echo "<div class='mensaje error'>Hubo un error</div>";
                header('Location:'.base_url);
            }
        } else{
            echo "<div class='mensaje error'>Debes iniciar sesion para ver la publicacion!</div>";
            header("Refresh:5; url=" . base_url);
        }
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

    //funcion para mostrar el formulario de publicar
    public function publicar()
    {
        //comprobamos que el usuario este identificado
        if(utils::isIdentity()){
            //manda a la vista
            require_once 'views/publicaciones/publicar.php';

        } else{
            header('Location:'.base_url);
        }
    }

    //funcion para guardar una publicacion
    public function guardar()
    {
        //verificamos que el usuario este logeado
        if(utils::isIdentity()){
            //verificamos que post nos llegue bien
            if(isset($_POST) && !empty($_POST)){
                // die(var_dump($_POST));
                //comprobamos que los datos del post existan
                $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
                $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                $estado = isset($_POST['estado']) ? $_POST['estado'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;

                //creamos el arreglo de errores para guardar los errores de los campos
                $errores = array();

                //comprobamos que la imagen nos llegue bien
                if(isset($_FILES)){
                    // die(var_dump($_FILES));
                    $nombre = $_FILES['imagen']['name'];
                    $tipo = $_FILES['imagen']['type'];
                    $ruta_temporal = $_FILES['imagen']['tmp_name'];

                    //verificamos que tenga formato correcto
                    if($tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/gif"){
                        //si no existe la carpeta imagenes-subidas dentro de assets, la creamos
                        if(!is_dir('assets/imagenes-subidas/')){  
                            mkdir('assets/imagenes-subidas', 0777);  
                        }

                        move_uploaded_file($ruta_temporal, 'assets/imagenes-subidas/'.$nombre);  //mueve un archivo, aqui se mueve el archivo temporal a la carpeta o ruta imagenes-subidas/nombredelarchivo

                    } else{
                        $errores['imagen'] = "<div class='mensaje error'>El tipo de la imagen no es correcto</div>";
                    }

                } else{
                    $errores['imagen'] = "<div class='mensaje error'>Error al subir la imagen</div>";
                }

                //creamos el objeto del modelo publicacion
                $publicacion = new publicacion();

                //comprobamos que los datos vengan correctos para guardarlos en el objeto
                if(!empty(trim($categoria)) && $categoria != false)
                    $publicacion->setIdCategoria((int) mysqli_real_escape_string($publicacion->getDb(),$categoria));
                else
                    $errores['categoria'] = "<div class='mensaje error'>Error al seleccionar categoria</div>";

                if(!empty(trim($titulo)) && $titulo != false)
                    $publicacion->setTitulo(mysqli_real_escape_string($publicacion->getDb(),$titulo));
                else
                    $errores['titulo'] = "<div class='mensaje error'>El titulo no es correcto</div>";

                if(!empty(trim($precio)) && $precio != false)
                    $publicacion->setPrecio((float) mysqli_real_escape_string($publicacion->getDb(),$precio));
                else
                    $errores['precio'] = "<div class='mensaje error'>El precio no es correcto</div>";

                if(!empty(trim($descripcion)) && $descripcion != false)
                    $publicacion->setDescripcion(mysqli_real_escape_string($publicacion->getDb(),$descripcion));
                else
                    $errores['descripcion'] = "<div class='mensaje error'>La Descripccion viene vacia</div>";

                if(!empty(trim($estado)) && $estado != false)
                    $publicacion->setEstado(mysqli_real_escape_string($publicacion->getDb(),$estado));
                else
                    $errores['estado'] = "<div class='mensaje error'>El estado no es correcto</div>";

                if(!empty(trim($municipio)) && $municipio != false)
                    $publicacion->setMunicipio(mysqli_real_escape_string($publicacion->getDb(),$municipio));
                else
                    $errores['municipio'] = "<div class='mensaje error'>El municipio viene vacio</div>";

                $publicacion->setIdUsuario((int) $_SESSION['usuario_identificado']->id_usuario);
                $publicacion->setImagen($nombre);

                //verificamos que no haya ningun error
                if(count($errores) == 0){
                    //llamamos al metodo save del objeto para guardar la publicacion en la bd
                    $publicado = $publicacion->save();

                    if($publicado){
                        //creamos una session para indicarle al usuario que la publicacion se guardo 
                        if(!isset($_SESSION['publicacion'])){
                            $_SESSION['publicacion'] = "<div class='mensaje'>Producto publicado con exito!</div>";
                        }
                    } else{
                        if(!isset($_SESSION['publicacion'])){
                            $_SESSION['publicacion'] = "<div class='mensaje error'>Hubo un error al publicar el producto</div>";
                        }
                    }

                } else{
                    //creamos una session para los errores
                    if(!isset($_SESSION['publicacion_error'])){
                        $_SESSION['publicacion_error']  = $errores;
                    }
                }

            } else{
                echo "<div class='mensaje error'>Hubo un error</div>";
                header("Refresh:3; url=" . base_url);
            }

            header('Location:'.base_url.'?controller=publicacion&action=publicar');

        } else{
            header('Location:'.base_url);
        }
    }

    //funcion para mostrar el formulario de editar una publicacion
    public function editar()
    {
        //comprobamos que el usuario este identificado
        if(utils::isIdentity()){
            //comprobamos que nos llegue el id por get
            if(isset($_GET['id']) && !empty($_GET['id'])){
                // die(var_dump($_GET));
                $id = (int) $_GET['id'];

                //creamos un objeto del modelo publicacion
                $objPublicacion = new publicacion();

                //guardamos el id en el objeto
                $objPublicacion->setId($id);

                //llamamos el metodo getOne para obtener esa publicacion con ese id
                $publicacion = $objPublicacion->getOne()->fetch_object();

                //verificamos que la publicacion exista
                if($publicacion != null){
                    //comprobamos que esa publicacion sea del usuario que esta logueado
                    // var_dump($publicacion);
                    // die(var_dump($_SESSION));
                    if($publicacion->id_usuario == $_SESSION['usuario_identificado']->id_usuario){
                        //mandamos a la vista para que el usuario edite
                        require_once 'views/publicaciones/editar.php';
                    } else{
                        echo "<div class='mensaje error'>Solo puedes editar tus publicaciones!</div>";
                    }  
                } else{
                    echo "<div class='mensaje error'>Esa publicacion no existe!</div>";
                }
            } else{
                echo "<div class='mensaje error'>Hubo un error</div>";
                header("Refresh:3; url=" . base_url);
            }
        } else{
            header('Location:'.base_url);
        }
    }

    //funcion para actualizar una publicacion
    public function actualizar()
    {
        //comrpobamos que el usuario este identificado 
        if(utils::isIdentity()){
            //verificamos que el post nos llegue bien
            if(isset($_POST) && !empty($_POST)){
                // die(var_dump($_POST));
                //comprobamos que los datos del post existan
                $id_publicacion = isset($_POST['id_publicacion']) ? $_POST['id_publicacion'] : false;
                $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
                $imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;
                $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : false;
                $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
                $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
                $estado = isset($_POST['estado']) ? $_POST['estado'] : false;
                $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;

                //creamos el arreglo de errores para guardar los errores de los campos
                $errores = array();

                //comprobamos que la imagen nos llegue bien
                if(isset($_FILES) && !empty($_FILES['imagen']['name']) && !empty($_FILES['imagen']['type']) && !empty($_FILES['imagen']['tmp_name'])){
                    // die(var_dump($_FILES));
                    $nombre = $_FILES['imagen']['name'];
                    $tipo = $_FILES['imagen']['type'];
                    $ruta_temporal = $_FILES['imagen']['tmp_name'];

                    //verificamos que tenga formato correcto
                    if($tipo == "image/jpg" || $tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/gif"){
                        //si no existe la carpeta imagenes-subidas dentro de assets, la creamos
                        if(!is_dir('assets/imagenes-subidas/')){  
                            mkdir('assets/imagenes-subidas', 0777);  
                        }

                        move_uploaded_file($ruta_temporal, 'assets/imagenes-subidas/'.$nombre);  //mueve un archivo, aqui se mueve el archivo temporal a la carpeta o ruta imagenes-subidas/nombredelarchivo
                        $imagen = $nombre;
                    } else{
                        $errores['imagen'] = "<div class='mensaje error'>El tipo de la imagen no es correcto</div>";
                    }
                }

                //creamos el objeto del modelo publicacion
                $publicacion = new publicacion();

                //comprobamos que los datos vengan correctos para guardarlos en el objeto
                if(!empty(trim($categoria)) && $categoria != false)
                    $publicacion->setIdCategoria((int) mysqli_real_escape_string($publicacion->getDb(),$categoria));
                else
                    $errores['categoria'] = "<div class='mensaje error'>Error al seleccionar categoria</div>";

                if(!empty(trim($titulo)) && $titulo != false)
                    $publicacion->setTitulo(mysqli_real_escape_string($publicacion->getDb(),$titulo));
                else
                    $errores['titulo'] = "<div class='mensaje error'>El titulo no es correcto</div>";

                if(!empty(trim($precio)) && $precio != false)
                    $publicacion->setPrecio((float) mysqli_real_escape_string($publicacion->getDb(),$precio));
                else
                    $errores['precio'] = "<div class='mensaje error'>El precio no es correcto</div>";

                if(!empty(trim($descripcion)) && $descripcion != false)
                    $publicacion->setDescripcion(mysqli_real_escape_string($publicacion->getDb(),$descripcion));
                else
                    $errores['descripcion'] = "<div class='mensaje error'>La Descripccion viene vacia</div>";

                if(!empty(trim($estado)) && $estado != false)
                    $publicacion->setEstado(mysqli_real_escape_string($publicacion->getDb(),$estado));
                else
                    $errores['estado'] = "<div class='mensaje error'>El estado no es correcto</div>";

                if(!empty(trim($municipio)) && $municipio != false)
                    $publicacion->setMunicipio(mysqli_real_escape_string($publicacion->getDb(),$municipio));
                else
                    $errores['municipio'] = "<div class='mensaje error'>El municipio viene vacio</div>";

                $publicacion->setId((int) $id_publicacion);
                $publicacion->setImagen($imagen);

                //verificamos que no haya ningun error
                if(count($errores) == 0){
                    //llamamos al metodo update del objeto para actualizar la publicacion en la bd
                    $actualizado = $publicacion->update();
                    
                    if($actualizado){
                        //creamos una session para indicarle al usuario que la actualizacion se guardo 
                        if(!isset($_SESSION['publicacion'])){
                            $_SESSION['publicacion'] = "<div class='mensaje'>Publicacion actualizada con exito!</div>";
                        }
                    } else{
                        if(!isset($_SESSION['publicacion'])){
                            $_SESSION['publicacion'] = "<div class='mensaje error'>Hubo un error al actualizar la publicacion</div>";
                        }
                    }
                } else{
                    //creamos una session para los errores
                    if(!isset($_SESSION['publicacion_error'])){
                        $_SESSION['publicacion_error']  = $errores;
                        }
                    }
            } else{
                echo "<div class='mensaje error'>Hubo un error</div>";
                header("Refresh:3; url=" . base_url);
            }

            header('Location:'.base_url.'?controller=publicacion&action=editar&id='.$id_publicacion);

        } else{
            header('Location:'.base_url);
        }

    }
}