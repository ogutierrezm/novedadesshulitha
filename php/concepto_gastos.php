<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_CONCEPTO_GASTOS':
			$respuesta = insertConceptosGastos($parametros);
			break;
		case 'LLENAR_GRID_CONCEPTO_GASTOS':
			$respuesta = llenarGridConceptoGastos();
			break;
		case 'CONSULTA_INFO_CONCEPTO_GASTOS':
			$respuesta = consultarInfoConceptoGastos($parametros['idConcepto']);
			break;
		case 'ELIMINADO_LOGICO_CONCEPTO_GASTOS':
			$respuesta = eliminarConceptoGastos($parametros);
			break;
		case 'AUTOCOMPLETE_CONCEPTO_GASTOS':
			$respuesta = consultaConceptoGastos($parametros);
			break;
		case 'LLENAR_GRID_CONCEPTO_GASTOS_REPORTE':
			$respuesta = llenarGridConceptoGastosReporte($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;

?>