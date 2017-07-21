<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$horas = (ISSET($_POST['horas'])?$_POST['horas']:'') ;
	$st3 = (ISSET($_POST['st3'])? $_POST['st3']:'');
	$id_articulo = (ISSET($_POST['sku'])?$_POST['sku']:0);
	$id_grupo = (ISSET($_POST['grupo'])?$_POST['grupo']:0);
	$precio = (ISSET($_POST['precio'])?$_POST['precio']:0);
	$cantidad = (ISSET($_POST['cantidad'])? $_POST['cantidad']:0);
	$articulo = (ISSET($_POST['articulo'])?$_POST['articulo']:'');
	
	$Respuesta = array("success"=>"false","data"=>"","error"=>"Operaci&oacute;n incorrecta para trabajar el inventario");
	
	if( $funcion == 1){	
		$Respuesta = obtenerSKU();
		echo json_encode($Respuesta);
	}elseif( $funcion == 2){
		if(validarDatosInventario($horas,$st3,$precio,$cantidad,$articulo)){
			$Respuesta = grabarArticuloNew($horas,$st3,$precio,$cantidad,$articulo);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o ya se encuentra registrado el art&iacute;culo!");
			echo json_encode($Respuesta);
			return false;
		}
	}elseif( $funcion == 3){
		if(validarDatosInventario($horas,$st3,$precio,$cantidad,$articulo)&& $id_articulo > 0){
			$Respuesta = actualizarArticuloInventario($id_articulo,$articulo,$cantidad,$precio,$st3,$horas);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o ya se encuentra registrado el art&iacute;culo!");
			echo json_encode($Respuesta);
			return false;
		}
	}elseif( $funcion == 4){
		$Respuesta = LlenarGridArticulosInventario();
		echo json_encode($Respuesta);
		return true;
	}elseif( $funcion == 5){
		if($id_articulo > 0){
			$Respuesta = deleteInventarioArticulo($id_articulo);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al eliminar el art&iacute;culo o ya no se encuentra registrado!");
			echo json_encode($Respuesta);
			return false;
		}
	}elseif( $funcion == 6){
		if($id_articulo > 0){
			$Respuesta = ligarInventarioaGrupo($id_articulo,$id_grupo);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al ligar el art&iacute;culo al grupo de inventario!");
			echo json_encode($Respuesta);
			return false;
		}
	}else{
		echo json_encode($Respuesta);	
		return false;
	}
	
	
	function validarDatosInventario($horas,$st3,$precio,$cantidad,$articulo){
		if ($horas < 0){
			return false;
		}elseif ($st3 < 0 || $st3 > 1){
			return false;
		}elseif ($precio < 0){
			return false;
		}elseif ($cantidad < 0){
			return false;
		}else if ($articulo == ''){
			return false;
		}else{
			return true;
		}
	}
?>