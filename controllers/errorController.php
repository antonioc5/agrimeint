<?php

//clase para mostrar los errores con el controlador
class errorController{
	
	//la funcion index, es el metodo que siempre se ejecutara por defecto
	public static function index(){
		echo "<h1>La página que buscas no existe</h1>";
	}
	
}