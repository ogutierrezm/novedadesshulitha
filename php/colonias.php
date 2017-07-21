<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	
	if( $funcion == 1){
		$Respuesta = LlenarComboColoniasSepomex(0,'');
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		$Respuesta = LlenarComboColoniasSepomex2(0,'');
		echo json_encode($Respuesta);
	}
	
?>