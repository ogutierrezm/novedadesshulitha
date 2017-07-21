<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');
	
	session_start();
	
	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];

	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_INVENTARIO':
			$respuesta = insertInventario($parametros);
			break;
		case 'LLENAR_GRID_INVENTARIO':
			$respuesta = llenarGridIventario();
			break;
		case 'CONSULTA_INFO_INVENTARIO':
			$respuesta = consultarInfoInventario($parametros['id']);
			break;
		case 'VALIDA_TOTALES':
			$respuesta = fn_revisarTotalesInventarios($parametros['id']);
		break;
		case 'CONFIRMAR_INVENTARIO':
			$respuesta = fn_confirmarInventario($parametros['id'], $_SESSION['keyx']);
		break;
		case 'LLENAR_GRID_INVENTARIO_REPORTE':
			$respuesta = llenarGridInventarioReporte($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;
?>