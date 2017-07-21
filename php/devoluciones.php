<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	session_start();

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'LLENAR_GRID_DEVOLUCIONES':
			$respuesta = llenarGridIDevoluciones();
			break;
		case 'REALIZAR_DEVOLUCION':
			$respuesta = realizarDevolucion($parametros['id']);
			break;
		case 'LLENAR_GRID_DEVOLUCIONES_REPORTE':
			$respuesta = llenarGridIDevolucionesReporte($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;

?>