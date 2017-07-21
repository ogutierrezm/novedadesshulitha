<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_PROVEEDORES':
			$respuesta = insertProveedores($parametros);
			break;
		case 'LLENAR_GRID_PROVEEDORES':
			$respuesta = llenarGridProveedores();
			break;
		case 'CONSULTA_INFO_PROVEEDORES':
			$respuesta = consultarInfoProveedor($parametros['idProveedor']);
			break;
		case 'ELIMINADO_LOGICO_PROVEEDORES':
			$respuesta = eliminarProveedor($parametros['idProveedor'], $parametros['activo']);
			break;
		case 'AUTOCOMPLETE_PROVEEDORES':
			$respuesta = consultaProveedores($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;
?>