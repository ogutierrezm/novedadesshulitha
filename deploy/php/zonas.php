<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	

	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$nombrezona = (ISSET($_POST['nombrezona'])? $_POST['nombrezona']:'');
	$desczona = (ISSET($_POST['desczona'])?$_POST['desczona']:'');
	$iCodigo = (ISSET($_POST['CodigoPostal'])? $_POST['CodigoPostal']:0);
	$vCalle = (ISSET($_POST['Colonia'])?$_POST['Colonia']:'');
	$iRegion = (ISSET($_POST['iRegion'])? $_POST['iRegion']:0);
	$iKeyxDir = (ISSET($_POST['iKeyxDir'])? $_POST['iKeyxDir']:0);
	
	$Respuesta = array("success"=>"false","data"=>"","error"=>"Operaci&oacute;n incorrecta para trabajar las zonas");
	
	if( $funcion == 1){
		if(validarDatosZonaNva($nombrezona,$desczona)){
			$Respuesta = GrabarNvaZona($nombrezona,$desczona);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien la zona ya se encuentra registrada!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 2){
	//print_r($iCodigo);
		/*if(validarDatosCPyCalle($iCodigo,$vCalle)){*/
			$Respuesta = LlenarComboColoniasSepomex($iCodigo,$vCalle);
			echo json_encode($Respuesta);
			return true;
		/*}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se encontr&oacute; informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}*/
	}else if( $funcion == 3){
	//print_r($iCodigo);
		if(validarDatosCPyCalle2($iCodigo,$vCalle)){
			$Respuesta = LlenarComboColoniasSepomex2($iCodigo,$vCalle);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se encontr&oacute; informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 4){
		if(validarNuevaZona($iRegion,$iKeyxDir)){
			$Respuesta = grabarRegionColonia($iRegion,$iKeyxDir);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se guard&oacute; la informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 5){
			$Respuesta = LlenarGridZonasNColonias();
			echo json_encode($Respuesta);
			return true;
	}else if( $funcion == 6){
			$Respuesta = LlenarGridZonas();
			echo json_encode($Respuesta);
			return true;
	}else if( $funcion == 7){
		if(validarDatosZonaNva($nombrezona,$desczona) && $iRegion > 0){
			$Respuesta = actualizarRegion($iRegion,$nombrezona,$desczona);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se guard&oacute; la informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 8){
		if($iRegion > 0){
			$Respuesta = eliminarRegion($iRegion);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se guard&oacute; la informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 9){
		if($iRegion > 0 && $iKeyxDir > 0){
			$Respuesta = actualizarZonaRegion($iKeyxDir,$iRegion);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se guard&oacute; la informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else if( $funcion == 10){
		if($iRegion > 0){
			$Respuesta = eliminarColoniaZona($iRegion);
			echo json_encode($Respuesta);
			return true;
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se guard&oacute; la informaci&oacuten.!");
			echo json_encode($Respuesta);
			return false;
		}
	}else{
		echo json_encode($Respuesta);	
		return false;
	}
	
	
	function validarDatosZonaNva($nombrezona,$desczona){
		if ($nombrezona == ''){
			return false;
		}else if ($desczona == ''){
			return false;
		}else{
			return true;
		}
	}
	
	function validarDatosCPyCalle($codigoPostal,$Calle){
		if ($codigoPostal >= 0){
			return false;
		}else if ($codigoPostal == ''){
			return false;
		//}else if ($Calle == ''){
		//	return false;
		//}else if (strlen($Calle) >= 3){
		//	return false;
		}else{
			return true;
		}
	}
	
	function validarDatosCPyCalle2($codigoPostal,$Keyx){
		if (strlen($codigoPostal) <= 3 && $Keyx <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function validarNuevaZona($iRegion,$iKeyxDir){
		if ($iRegion <= 0 || $iKeyxDir <= 0){
			return false;
		}else{
			return true;
		}
	}
?>