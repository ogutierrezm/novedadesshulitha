<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	include('../conx/constant.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$keyx = (ISSET($_POST['keyx'])? $_POST['keyx']:0);
	$vFoliopedido = (ISSET($_POST['foliopedido'])? $_POST['foliopedido']:0);
	$vId_articulo = (ISSET($_POST['id_articulo'])? $_POST['id_articulo']:0);
	$vCantidad = (ISSET($_POST['cantidad'])? $_POST['cantidad']:0);
	$fechaentrega = (ISSET($_POST['fechaentrega'])? $_POST['fechaentrega']:'');
	if( $funcion == 1){
		if(ValidarNumero($keyx)){
			$esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
			if ($vFoliopedido == 0){
				$Respuesta = articulosConsultarPorKeyx($keyx,$esRenta,$fechaentrega,0);
			}else {
				$Respuesta = articulosConsultarPorKeyx($keyx,$esRenta,$fechaentrega,$vFoliopedido);
			}
			//print_r($Respuesta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		if(ValidarNumero($keyx)){
			$Respuesta = articulosEspecialConsultarPorKeyx($keyx,$fechaentrega);
			//print_r($Respuesta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
		if(ValidarRegresoArticulos($vFoliopedido,$vId_articulo,$vCantidad)){
			$Respuesta = devolverArticuloaInventario($vFoliopedido,$vId_articulo,$vCantidad);
			//print_r($Respuesta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n!");
		}
		echo json_encode($Respuesta);
	}
	
	function ValidarNumero($keyx){
		if ($keyx <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function ValidarRegresoArticulos($vFoliopedido,$vId_articulo,$vCantidad){
		if ($vFoliopedido <= 0){
			return false;
		}else if ($vId_articulo <= 0){
			return false;
		}else if ($vCantidad <= 0){
			return false;
		}else{
			return true;
		}
	}
?>