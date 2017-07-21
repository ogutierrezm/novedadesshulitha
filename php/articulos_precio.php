<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'CONSULTA_ARTICULOS_PRECIO':
			$respuesta = consultarInfoArticuloPrecio($parametros['id']);
			break;
		case 'GRABAR_PRECIOS_ARTICULOS':
			$respuesta = fn_articulos_precio($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;

?>