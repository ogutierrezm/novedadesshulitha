<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	session_start();

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	$respuesta = null;
	
	switch ($categoria) {
		case 'BUSQUEDA_INFO_CUENTA_INCOBRABLE':
			$respuesta = busqueda_info_cuenta_incobrable($parametros);
			break;
		case 'CREAR_CUENTA_INCOBRABLE':
			$respuesta = crear_cuenta_incobrable($parametros);
			break;
		case 'GRID_CUENTAS_INCOBRABLES';
			$respuesta = llenarGridCuentasIncobrables();
			break;
		case 'OBTENER_JUSTIFICACION':
			$respuesta = verJustificacionCtaIncobrables($parametros);
			break;
		default: break;
	}
	echo $respuesta;
?>