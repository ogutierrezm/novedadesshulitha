<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	session_start();

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'LLENAR_GRID_CORTE_ANTERIORES':
			$respuesta = llenarGridCortesAnteriores($parametros);
			break;
		case 'LLENAR_GRID_CORTE_ANTERIORES_DETALLE':
			$respuesta = llenarGridCortesAnterioresDetalle($parametros);
			break;
		case 'REALIZAR_CORTE':
			$respuesta = realizar_corte();
			break;
		case 'OBTENER_FECHAS_CORTE':
			$respuesta = obtenerFechasCorte();
			break;
		case 'REALIZAR_PRE_CORTE':
			$respuesta = llenarGridPreCorte();
			break;
		default:
			break;
	}
	echo $respuesta;

?>