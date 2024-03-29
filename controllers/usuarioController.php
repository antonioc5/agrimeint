<?php
require_once 'models/usuario.php';

class usuarioController
{

    public function index()
    {
        //echo "Controlador usuarios, accion index";
        $this->registro();
    }

    //funcion para ver el formulario de registro
    public function registro()
    {
        if (!utils::isIdentity())
            require_once 'views/usuarios/registro-entrar.php';

        else
            header("Location:" . base_url);
    }

    //funcion para guardar un usuario en la bd
    public function guardar()
    {
        //primero comprobamos que nos llegue post y que no venga vacio
        if (isset($_POST) && !empty($_POST)) {
            // var_dump($_POST); //para ver los valores que contiene post

            //verificamos que los campos del formulario existan
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            //creamos un objeto del modelo usuario
            $usuario = new usuario();

            //creamos un arreglo para guardar los errores que contengan los campos
            $errores = array();

            //verificamos que esos campos no vengan vacios y que vengan correctos, y los limpiamos y los escapamos para mandarlos seguros
            if (!empty(trim($nombre)) && !is_numeric($nombre) && $nombre != false)
                $usuario->setNombre(mysqli_real_escape_string($usuario->getDb(), $nombre));
            else
                $errores['nombre'] = "El nombre no es correcto";

            if (!empty(trim($apellidos)) && !is_numeric($apellidos) && $apellidos != false)
                $usuario->setApellidos(mysqli_real_escape_string($usuario->getDb(), $apellidos));
            else
                $errores['apellidos'] = "Los apellidos no son correctos";

            if (!empty(trim($email)) && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) && $email != false)
                $usuario->setEmail(mysqli_real_escape_string($usuario->getDb(), $email));
            else
                $errores['email'] = "El email no es correcto";

            if (!empty(trim($telefono)) && is_numeric($telefono) && $telefono != false)
                $usuario->setTelefono(mysqli_real_escape_string($usuario->getDb(), $telefono));
            else
                $errores['telefono'] = "El telefono no es correcto";

            if (!empty(trim($password)) && $password != false)
                $usuario->setPassword(mysqli_real_escape_string($usuario->getDb(), $password));
            else
                $errores['password'] = "La contraseña viene vacia, favor de rellenarla";

            // var_dump($errores);
            // die();

            //verificamos no haya habido ningun error
            if (count($errores) == 0) {
                //ahora verificamos que el email que haya introducido no este registrado
                $query = "select email from usuario where email = '{$usuario->getEmail()}';";
                $email_ok = mysqli_query($usuario->getDb(), $query);

                if (mysqli_num_rows($email_ok) == 0) {
                    //no hubo ningun email igual
                    //encriptamos la password para ya mandar los datos a la bd
                    $password_encriptada = password_hash($usuario->getPassword(), PASSWORD_BCRYPT, ['costo' => 12]);
                    $usuario->setPassword($password_encriptada);

                    //insertamos los datos a la db con la funcion save del objeto usuario
                    $save = $usuario->save();

                    // var_dump($save);
                    // die(mysqli_error($usuario->getDb()));

                    if ($save) {
                        //mandaremos un mensaje al usuario mediante la session, indicandole que su registro fue correcto
                        if (!isset($_SESSION['registro']))
                            $_SESSION['registro'] = "ok";
                    } else {
                        //hubo un error con la funcion save
                        // $_SESSION['registro'] = "fallido";
                        // var_dump($_SESSION);
                        // die();
                    }
                } else {
                    //el email ya esta registrado
                    //crearemos la session de registro y le diremos al usuario que el email ya existe, mediante la session
                    $errores['email'] = "El email ya esta registrado, intenta con otro";

                    if (!isset($_SESSION['registro']))
                        $_SESSION['registro'] = $errores;

                    if (isset($_SESSION['registro']))
                        $_SESSION['registro'] = $errores;

                    // var_dump($_SESSION);
                    // die();
                }
            } else {
                //hay algun dato incorrecto
                //redireccionamos al index y ahi en el formulario es donde le indicaremos al usuario en donde estuvo el error
                //lo haremos mediante una session creando una sesion de registro y asignandole el arreglo de errores (tambien puede ser mediante GET), asi al redireccionar mantendremos los errores con la sesion y podemos mostrarlos
                //la session con los errores se mostrara en la pagina del formulario 
                //session_start(); ya viene incluida en el include de conexion
                if (!isset($_SESSION['registro']))
                    $_SESSION['registro'] = $errores;

                if (isset($_SESSION['registro']))
                    $_SESSION['registro'] = $errores;
                // var_dump($_SESSION);
                // die();
            }

            //redireccionamos a la pagina de registro
            header('Location:' . base_url . '?controller=usuario&action=index');
        } else {
            //no existio post o llego vacio
            echo "<div class='mensaje error'>Hubo un error</div>";
            header("Refresh:4; url=" . base_url);
        }
    }

    //funcion para iniciar sesion
    public function login()
    {
        //comprobamos que nos llegue bien el post
        if (isset($_POST) && !empty($_POST)) {
            //var_dump($_POST);
            //comprobamos que los datos nos lleguen
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            //creamos un arreglo para guardar errores
            $errores = array();

            //creamos un objeto del modelo usuario
            $usuario = new usuario();

            //verificamos que los datos no esten vacios o no vengan mal y los guardamos en el objeto
            if (!empty(trim($email)) && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) && $email != false)
                $usuario->setEmail(mysqli_real_escape_string($usuario->getDb(), $email));
            else
                $errores['email'] = "El email no es correcto";

            if (!empty(trim($password)) && $password != false)
                $usuario->setPassword(mysqli_real_escape_string($usuario->getDb(), $password));
            else
                $errores['password'] = "La contraseña viene vacia, favor de rellenarla";

            //verificamos que no haya ningun error
            if (count($errores) == 0) {
                //llamamos el metodo login
                $login = $usuario->login();
                // var_dump($login);
                // die();

                if ($login['resultado']) {
                    //creamos una session para el usuario
                    if (!isset($_SESSION['usuario_identificado'])) {
                        $_SESSION['usuario_identificado'] = $login['usuario'];
                    }
                } else {
                    //creamos una sessiones de errores
                    if (!isset($_SESSION['login_errores'])) {
                        $_SESSION['login_errores'] = $login['error'];
                    }
                }
            } else {
                //creamos una session de errores
                if (!isset($_SESSION['login_errores_campos'])) {
                    $_SESSION['login_errores_campos'] = $errores;
                }
            }

            //redireccionamos a la pagina de registro
            header('Location:' . base_url);
        } else {
            echo "<div class='mensaje error'>Hubo un error</div>";
            header("Refresh:3; url=" . base_url);
        }
    }

    //funcion para cerrar sesion
    public function logout()
    {
        utils::deleteSession("usuario_identificado");
        header('Location:' . base_url);
    }

    //funcion para ver mi cuenta
    public function miCuenta()
    {
        //comprobamos que el usuario este identificado
        if (utils::isIdentity()) {
            //guardamos los datos del usuario
            $usuario = $_SESSION['usuario_identificado'];
            // var_dump($usuario);

            //mandamos a la vista
            require_once 'views/usuarios/mi-cuenta.php';
        } else {
            header('Location:' . base_url);
        }
    }

    //funcion para actualizar los datos del usuario
    public function actualizar()
    {
        //comprobamos que el usuario este identificado
        if (utils::isIdentity()) {
            //comprobamos que nos llegue bien el post
            if (isset($_POST) && !empty($_POST)) {
                // var_dump($_POST);
                //comprobamos que los datos del post existan
                $id = isset($_POST['id']) ? $_POST['id'] : false;
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;
                
                //creamos un arreglo de errores para guardar los posibles errores en los campos
                $errores = array();

                //creamos un objeto del modelo usuario
                $usuario = new usuario();

                //comprobamos que los datos vengan correctos
                if (!empty(trim($id)) && is_numeric($id) && $id != false)
                    $usuario->setId(mysqli_real_escape_string($usuario->getDb(), $id));
                else
                    $errores['id'] = "El id no es correcto";

                if (!empty(trim($nombre)) && !is_numeric($nombre) && $nombre != false)
                    $usuario->setNombre(mysqli_real_escape_string($usuario->getDb(), $nombre));
                else
                    $errores['nombre'] = "El nombre no es correcto";

                if (!empty(trim($apellidos)) && !is_numeric($apellidos) && $apellidos != false)
                    $usuario->setApellidos(mysqli_real_escape_string($usuario->getDb(), $apellidos));
                else
                    $errores['apellidos'] = "Los apellidos no son correctos";

                if (!empty(trim($telefono)) && is_numeric($telefono) && $telefono != false)
                    $usuario->setTelefono(mysqli_real_escape_string($usuario->getDb(), $telefono));
                else
                    $errores['telefono'] = "El telefono no es correcto";

                //comprobamos que no haya ningun error
                if(sizeof($errores) == 0){
                    //llamamos el metodo que va actualizar al usuario (modificar)
                    $actualizado = $usuario->modificar();

                    // echo mysqli_error($usuario->getDb());
                    // die();

                    //comprobamos que se haya ejecutado correctamente la consulta
                    if($actualizado){
                        //sacamos el usuario de la bd para obtener sus nuevos datos
                        $usuario_actualizado = $usuario->getUsuario();
                        // var_dump($usuario_actualizado);
                        // var_dump($_SESSION);

                        if($usuario_actualizado){
                            //actualizamos la session del usuario con sus nuevos datos
                            if(isset($_SESSION['usuario_identificado'])){
                                $_SESSION['usuario_identificado'] = $usuario_actualizado;
                            }
                        }

                        //creamos una session para indicar que la actualizacion fue correcta
                        if(!isset($_SESSION['actualizar'])){
                            $_SESSION['actualizar'] = "<div class='mensaje'>Datos actualizados correctamente!</div>";
                        }
                    } else{
                        //creamos una session para indicar que fallo la actualizacion
                        if(!isset($_SESSION['actualizar'])){
                            $_SESSION['actualizar'] = "<div class='mensaje error'>Hubo un error al actualizar</div>";
                        }
                    }
                } else{
                    //creamos una session de errores
                    if(!isset($_SESSION['actualizar_errores'])){
                        $_SESSION['actualizar_errores'] = $errores;
                    }
                }

                header('Location:'.base_url.'?controller=usuario&action=miCuenta');

            } else {
                echo "<div class='mensaje error'>Hubo un error</div>";
                header("Refresh:3; url=" . base_url);
            }
        } else {
            header('Location:' . base_url);
        }
    }
}
