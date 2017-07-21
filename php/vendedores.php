<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	//print_r($categoria);
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_VENDEDORES':
			$respuesta = insertVendedores($parametros);
			break;
		case 'LLENAR_GRID_VENDEDORES':
			$respuesta = llenarGridVendedores();
			break;
		case 'AUTOCOMPLETE_PUESTO_VENDEDOR':
			$respuesta = consultaPuestos($parametros);
			break;
		case 'CONSULTA_INFO_VENDEDORES':
			$respuesta = consultarInfoVendedores($parametros['id_vendedor']);
			break;
		case 'ELIMINADO_LOGICO_VENDEDORES':
			$respuesta = eliminarVendedor($parametros['id_vendedor'], $parametros['activo']);
			break;
		default:
			break;
	}
	echo $respuesta;

?>