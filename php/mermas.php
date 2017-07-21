<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'LLENAR_GRID_MERMAS':
			$respuesta = llenarGridMermas($parametros);
			break;
		case 'CONSULTA_INFORMACION_ARTICULOS_MERMA':
			$respuesta = consultaInformacionArticulosMermas($parametros);
			break;
		case 'CREAR_ARTICULO_MERMA':
			$respuesta = crearArticuloMerma($parametros);
			break;
		case 'LLENAR_GRID_MERMAS_REPORTE':
			$respuesta = llenarGridMermaReporte($parametros);
			break;
		default; break;
	}
	echo $respuesta;
?>