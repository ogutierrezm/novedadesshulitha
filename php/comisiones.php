<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$iFolioPedido = (ISSET($_POST['foliopedido'])? $_POST['foliopedido']:0);	
	$bCliente = (ISSET($_POST['cliente'])? $_POST['cliente']:0);	
	$dComision = (ISSET($_POST['monto'])? $_POST['monto']:0);	

	
	if( $funcion == 1){
		$Respuesta = PagarComisionVenta($iFolioPedido,$bCliente,$dComision);
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		$Respuesta = PagarComisionCobranza($iFolioPedido,$bCliente,$dComision);
		echo json_encode($Respuesta);
	}

	
	function ValidarInteger($entero){
		if ($entero <= 0){
			return false;
		}else{
			return true;
		}
	}
?>