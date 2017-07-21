<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	/*$usuario = (ISSET($_POST['usuario'])?$_POST['usuario']:'') ;
	$keyx = (ISSET($_POST['keyx'])? $_POST['keyx']:0);
	$puesto = (ISSET($_POST['puesto'])? $_POST['puesto']:0);
	$nombre1 = (ISSET($_POST['nombre'])?$_POST['nombre']:'');
	$apellido1 = (ISSET($_POST['apellido'])?$_POST['apellido']:'');
	$nombre = $nombre1. " ". $apellido1 ;
	$password = (ISSET($_POST['password'])?$_POST['password']:'') ;
	$confirmarcontrasena = (ISSET($_POST['confirmarcontrasena'])?$_POST['confirmarcontrasena']:'') ;*/
	if( $funcion == 1){
		$Respuesta = obtenerFolioOrden();
		echo json_encode($Respuesta);
	}
	
	
	
?>