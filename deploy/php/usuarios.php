<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$usuario = (ISSET($_POST['usuario'])?$_POST['usuario']:'') ;
	$keyx = (ISSET($_POST['keyx'])? $_POST['keyx']:0);
	$puesto = (ISSET($_POST['puesto'])? $_POST['puesto']:0);
	$nombre1 = (ISSET($_POST['nombre'])?$_POST['nombre']:'');
	$apellido1 = (ISSET($_POST['apellido'])?$_POST['apellido']:'');
	$nombre = $nombre1. " ". $apellido1 ;
	$password = (ISSET($_POST['password'])?$_POST['password']:'') ;
	$confirmarcontrasena = (ISSET($_POST['confirmarcontrasena'])?$_POST['confirmarcontrasena']:'') ;
	if( $funcion == 1){
		if( $usuario!== '')
		{
			if(validarDatosUsr($usuario,$puesto,$nombre,$password,$confirmarcontrasena)){
				$Respuesta = GrabarUsuarioNuevo($puesto,$usuario,$password,$nombre);
			}else{
				$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
			}
			echo json_encode($Respuesta);
		}
	}else if( $funcion == 2){		
		$Respuesta = eliminarUsuario($puesto);
		echo json_encode($Respuesta);
	}else if( $funcion == 3){		
		$Respuesta = LlenarGridUsuarios();
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		if( $usuario!== '')
		{
			//fn_user_update(iKeyx INTEGER,iId_puesto INTEGER,cUser VARCHAR,cPwd VARCHAR,cNombre VARCHAR)
			if(validarDatosUsr($usuario,$puesto,$nombre,$password,$confirmarcontrasena)){
				$Respuesta = actualizarUsuario($keyx,$puesto,$usuario,$password,$nombre);
			}else{
				$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
			}
			echo json_encode($Respuesta);
		}
	}
	
	function validarDatosUsr($usuario,$puesto,$nombre,$password,$confirmarcontrasena){
		if ($usuario == ''){
			return false;
		}else if ($puesto <= 0){
			return false;
		}else if ($nombre == ''){
			return false;
		}else if ($password == ''){
			return false;
		}else if ($confirmarcontrasena == ''){
			return false;
		}else if ($confirmarcontrasena !== $password){
			return false;
		}else{
			return true;
		}
	}
?>