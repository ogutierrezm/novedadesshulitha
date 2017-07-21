<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_ARTICULOS':
			$respuesta = insertArticulos($parametros);
			break;
		case 'LLENAR_GRID_ARTICULOS':
			$respuesta = llenarGridArticulos();
			break;
		case 'CONSULTA_INFO_ARTICULO':
			$respuesta = consultarInfoArticulo($parametros['id']);
			break;
		case 'ELIMINADO_LOGICO_ARTICULOS':
			$respuesta = eliminarArticulo($parametros['id'], $parametros['activo']);
			break;
		case 'AUTOCOMPLETE_CONCEPTO_GASTOS':
			$respuesta = consultaConceptoGastos($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;

?>