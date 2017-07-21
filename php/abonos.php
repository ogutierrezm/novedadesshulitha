<?php
	include('../conx/constant.php');
	include('../conx/conexiones.php');	
	include_once ('../calls/fn_generales.php');

	session_start();

	$parametros = json_decode($_POST['parametros'], true);
	$categoria = $parametros['categoria'];
	
	$respuesta = null;
	switch ($categoria) {
		case 'ALTA_ABONOS':
			$respuesta = insertAbonos($parametros);
			break;
		case 'LLENAR_GRID_FACTURAS_PENDIENTES':
			$respuesta = llenarGridFacturasPendientesPagar();
			break; 
		case 'LLENAR_GRID_ABONOS':
			$respuesta = llenarGridAbonos($parametros['id']);
			break;
		case 'CONSULTA_INFO_ABONOS':
			$respuesta = fn_informacion_facturas_pagar($parametros['id']);
			break;
		case 'CANCELAR_ABONO':
			$respuesta = cancelarAbonos($parametros);
			break;
		case 'LLENAR_GRID_ABONOS_REPORTE':
			$respuesta = llenarGridIAbonosReporte($parametros);
			break;
		case 'LLENAR_GRID_ABONOS_REPORTE_2':
			$respuesta = llenarGridIAbonosReporte_2($parametros);
			break;
		case 'PAGO_CONTADO_FACTURA':
			$respuesta = fn_liquida_facturas_contado($parametros);
			break;
		case 'AUTOCOMPLETE_PUESTO_COBRADOR':
			$respuesta = fn_autocomplete_cobrador($parametros);
			break;
		case 'ACUMULADO_FACTURAS_ABONOS_PENDIENTES':
			$respuesta = fn_acumulado_facturas_abonos_pendientes($parametros);
			break;
		default:
			break;
	}
	echo $respuesta;

?>