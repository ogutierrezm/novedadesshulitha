<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_INVENTARIO_DETALLE':
			$respuesta = insertInventarioDetalle($parametros);
			break;
		case 'AUTOCOMPLETE_ARTICULOS':
			$respuesta = consultaArticulos($parametros);
			break;
		case 'LLENAR_GRID_INVENTARIO_DETALLE':
			$respuesta = llenarGridIventarioDetalle($parametros);
			break;
		case 'CONSULTA_INFO_INVENTARIO_DETALLE':
			$respuesta = consultarInfoInventarioDetalle($parametros['id'], $parametros['idInventarioDetalle']);
			break;
		case 'ELIMINADO_LOGICO_INVENTARIO_DETALLE':
			$respuesta = eliminarInventarioDetalle($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;
?>