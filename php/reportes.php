<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	

	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$dFechaInicio = (ISSET($_POST['fechainicio'])?$_POST['fechainicio']:'') ;
	$dFechaFin = (ISSET($_POST['fechafin'])?$_POST['fechafin']:'') ;
	
	$Respuesta = array("success"=>"false","data"=>"","error"=>"Operaci&oacute;n incorrecta para trabajar las zonas");
	
	if( $funcion == 1){
		$Respuesta = verFacturadosHoy();
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		$Respuesta = verCancelaciones();
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
		$Respuesta = verFacturadosPeriodo($dFechaInicio,$dFechaFin);
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		$Respuesta = verCancelacionesPeriodo($dFechaInicio,$dFechaFin);
		echo json_encode($Respuesta);
	}else if( $funcion == 5){
		$Respuesta = verComisionesPagadasPeriodo($dFechaInicio,$dFechaFin);
		echo json_encode($Respuesta);
	}else if( $funcion == 6){
		$Respuesta = verComisionesCobranzaPagadasPeriodo($dFechaInicio,$dFechaFin);
		echo json_encode($Respuesta);
	}
?>