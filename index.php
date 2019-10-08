<?php
session_start();

require_once 'autoload.php';
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'utils/utils.php';
require_once 'views/layout/header-index.php';
require_once 'views/layout/registro-entrar.php';
require_once 'views/layout/bienvenida.php';
require_once 'views/publicaciones/destacadas.php';


if(isset($_GET['controller'])){
	$nombre_controlador = $_GET['controller'].'Controller';

}
elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
	$nombre_controlador = controller_default;
	
}
else{
	errorController::index();
	exit();
}

if(class_exists($nombre_controlador)){	
	$controlador = new $nombre_controlador();
	
	if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
		$action = $_GET['action'];
		$controlador->$action();
	}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
		$action_default = action_default;
		$controlador->$action_default();
	}else{
		errorController::index();
	}
}else{
	errorController::index();
}

require_once 'views/layout/footer.php';


/*
el index es la primera pagina en cargar...
con el autoload se cargan todos los controladores automaticamente (sin necesidad de hacer un include para cada uno)
se pueden cargar los modelos o lo que se requiera pero en este caso cargaremos los controladores ya que usaremos todos estos con sus metodos


primero comprobamos que nos llegue el parametro get por la url llamado controller
si existe lo guardamos en la variable $controlador, y le concatenamos el texto sig. 'Controller',
hacemos esto porque todas las clases controladoras terminar por Controller, por ejemplo:
usuarioController, publicacionController, productoController, etc
en este caso si nos llega por la url esto http://127.0.0.1/agrimeint/?controller=usuario
la variable $controlador sera igual a 'usuarioController'
y si no llega ningun parametro llamado controller, usamos un controlador por defecto que sera el de productoControler o publicacionControler o etc, 
lo que quieras que muestre tu pagina la primera vez que la visiten. y la variable $controlador sera igual a el controlador por defecto
y si no llega nada o hay un error mostramos la clase errores y el metodo index directamente


ahora tenemos una variable que contiene un nombre de un controlador ejemplo
$controlador= usuarioController o etc

lo que sigue es comprobar si esa clase existe,
si la calse usuarioController existe entonces creamos un objeto de esta clase
!listo tenemos la clase lista!

ahora sigue comprobar la accion (la accion es el metodo del controlador), si por la url por get nos llega un parametro llamado action
y el valor de ese parametro action es un metodo de la clase del controlador, entonces
guardamos el valor de ese parametro get en la variable $action pro ejemplo:
$action=borrar, $action=registro, etc

si por la url no llega ese parametro get llamado action o si llego pero ese valor que tenia no es una clase, entonces
a la variable action le agregamos una accion por default que por lo general es el metodo index o la accion index, por lo general esta accion
siempre muestra las cosas principales como Ver, Listar o etc

!listo, ya tenemos la accion!
de echo ya tenemos todo, tenemos la clase, que nos llego por get, y tenemos tambien el action que igual nos llego por get y si no llego usamos los default que por lo general la clase default siempre son productos o publicaciones (lo que quieres que el usuario vea al entrar a la web) y el metodo siempre es el index que es el que muestra la info o lista productos o etc
hicimos un objeto de esa clase, y mandamos a llamar su metodo, el metodo lo sacamos del action

al final este metodo muestra info a hace alguna cosa que el usuario habia pedido

*/
