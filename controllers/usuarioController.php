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
        echo "<h3 class='fw-300 centrar-texto'>Inicia sesion o crea una cuenta nueva</h3>";

        require_once 'views/usuarios/registro-entrar.php';
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
            if (!empty($nombre) && !is_numeric($nombre))
                $nombre = mysqli_real_escape_string($usuario->getDb(), $nombre);
            else
                $errores['nombre'] = "El nombre no es correcto";

            if (!empty($apellidos) && !is_numeric($apellidos))
                $apellidos = mysqli_real_escape_string($usuario->getDb(), $apellidos);
            else
                $errores['apellidos'] = "Los apellidos no son correctos";

            if (!empty($email) && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
                $email = mysqli_real_escape_string($usuario->getDb(), $email);
            else
                $errores['email'] = "El email no es correcto";

            if (!empty($telefono) && is_numeric($telefono))
                $telefono = mysqli_real_escape_string($usuario->getDb(), $telefono);
            else
                $errores['telefono'] = "El telefono no es correcto";

            if (!empty($password))
                $password = mysqli_real_escape_string($usuario->getDb(), $password);
            else
                $errores['password'] = "La contraseña viene vacia, favor de rellenarla";

            // var_dump($errores);
            // die();

            //verificamos no haya habido ningun error
            if (count($errores) == 0) {
                //los datos estan correctos, los guardamos en el objeto usuario
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setTelefono($telefono);
                $usuario->setPassword($password);

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
            header('Location:'.base_url.'?controller=usuario&action=index');

        } else {
            //no existio post o llego vacio
            echo "<div class='mensaje error'>Hubo un error</div>";
        }
    }

    //funcion para iniciar sesion
    public function login()
    { 

    }
}
