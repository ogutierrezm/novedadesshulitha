<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$iFolioPedido = (ISSET($_POST['foliopedido'])? $_POST['foliopedido']:0);	
	$iAbono = (ISSET($_POST['iabono'])? $_POST['iabono']:0);	
	$vEmpleado = (ISSET($_POST['empleado'])? $_POST['empleado']:0);	
	$vRecibio = (ISSET($_POST['recibio'])? $_POST['recibio']:'');
	$vFechaMes = (ISSET($_POST['fechames'])? $_POST['fechames']:'');	
	$vFechaAnio = (ISSET($_POST['fechaanio'])? $_POST['fechaanio']:'');	
	$iEmpresa = (ISSET($_POST['empresa'])? $_POST['empresa']:0);
	$bKeyx = (ISSET($_POST['keyx'])? $_POST['keyx']:0);
	$iValor = (ISSET($_POST['valor'])? $_POST['valor']:0);
	$vEmail = (ISSET($_POST['email'])? $_POST['email']:'');
	$iTipoPago = (ISSET($_POST['tipopago'])? $_POST['tipopago']:0);	
	$iPlazo = (ISSET($_POST['plazo'])? $_POST['plazo']:0);
	$iNumReferencia = (ISSET($_POST['numreferencia'])? $_POST['numreferencia']:0);
	$vNombre = (ISSET($_POST['nombre'])? $_POST['nombre']:'');
	$vTelefono = (ISSET($_POST['telefono'])? $_POST['telefono']:'');
	$vDomicilio = (ISSET($_POST['domicilio'])? $_POST['domicilio']:'');
	
	if( $funcion == 1){
		$Respuesta = cmbArticulosExistencia();
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		$Respuesta = cmbTipoPago();
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
		if(ValidarInteger($iTipoPago)){
			$Respuesta = cmbPlazo($iTipoPago);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se encontro el plazo!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		if(ValidarInteger($iTipoPago)){
			$Respuesta = cmbPeriodoCobro($iTipoPago);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"No se encontro el periodo de cobro!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 5){
		$Respuesta = variables_select($bKeyx,$iEmpresa);
		echo json_encode($Respuesta);
	}else if( $funcion == 6){
		$Respuesta = consultarArticuloElegido($bKeyx);
		echo json_encode($Respuesta);
	}else if( $funcion == 7){
		if ($iTipoPago == 1){
			$Respuesta = itemPlazo(1,$iPlazo,0);
		}else{
			$Respuesta = itemPlazo($iTipoPago,$iPlazo,$bKeyx);
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 8){
		$Respuesta = grabadoReferenciasPedido($iFolioPedido,$iNumReferencia,$vNombre,$vTelefono,$vDomicilio);
		echo json_encode($Respuesta);
	}else if( $funcion == 9){
		$Respuesta = cmbVendedor();
		echo json_encode($Respuesta);
	}else if( $funcion == 10){
		$Respuesta = cmbSupervisor();
		echo json_encode($Respuesta);
	}else if( $funcion == 11){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = CancelarPedido($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al cancelar la factura!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 12){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = modificarFechaCobranza($iFolioPedido,$vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al cancelar la factura!");
		}
		echo json_encode($Respuesta);
	}
	
	
	
	/*else if( $funcion == 3){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = regresarArticulosAInventarioFolio($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		if(ValidarInteger($iFolioPedido) && ValidarInteger($iAbono)){
			$Respuesta = abonarAUnFolio($iFolioPedido,$iAbono,$vRecibio,$vEmpleado);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 5){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarArticulosParcialesUnPedidosPendiente($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 6){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarArticulosParcialesUnPedidosPendienteModal($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 7){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = eliminarPedido($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 8){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarUnPedidos($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 9){
		if($vFechaMes != '' && $vFechaAnio != ''){
			$Respuesta = generarReporteTodosLosPedidos($vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Es necesario seleccionar un mes y a&ntilde;o para realizar la consulta!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 10){
		if($vFechaMes != '' && $vFechaAnio != ''){
			$Respuesta = generarReportePedidosPorEmpleadoFecha($vEmpleado,$vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Es necesario seleccionar un empleado, mes y a&ntilde;o para realizar la consulta!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 11){
		if($vFechaMes != '' && $vFechaAnio != ''){
			$Respuesta = totalesEmpleadoPorPeriodo($vEmpleado,$vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Es necesario seleccionar un empleado, mes y a&ntilde;o para realizar la consulta!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 12){
		if($iFolioPedido > 0){
			$Respuesta = generarReporteAbonosXFolio($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Es necesario introducir un folio para realizar la consulta!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 13){
		$Respuesta = ModificarVariableEmpresa($bKeyx,$iEmpresa,$iValor);
		echo json_encode($Respuesta);
	}else if( $funcion == 14){
		$Respuesta = AniadirNotaAccesorios($iFolioPedido,$vRecibio);
		echo json_encode($Respuesta);
	}else if( $funcion == 15){
		$Respuesta = generarCortedeAbonos();
		echo json_encode($Respuesta);
	}else if( $funcion == 16){
		$Respuesta = generarCortedeAnticipos($vEmpleado);
		echo json_encode($Respuesta);
	}else if( $funcion == 17){
		$Respuesta = descartarBorrado($iFolioPedido,$vEmpleado);
		echo json_encode($Respuesta);
	}else if( $funcion == 18){
		$Respuesta = devolverDeposito($iFolioPedido,$iAbono,$vEmpleado);
		echo json_encode($Respuesta);
	}else if( $funcion == 19){
		$Respuesta = '';
		$Respuesta = array("retorno"=>($vFechaAnio <= $vFechaMes)?true:false);
		echo json_encode($Respuesta);
	}else if( $funcion == 20){
		$Respuesta = descartarModificado($iFolioPedido,$vEmpleado);
		echo json_encode($Respuesta);
	}else if( $funcion == 21){
		$Respuesta = fn_cortetda_select_paso1($vFechaAnio);
		echo json_encode($Respuesta);
	}else if( $funcion == 22){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = RestaurarPedidoBorrado($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 23){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = '';
			//$sResultado = consultarUnaCotizacionparaEmail($iFolioPedido);
			$sResultado = consultarUnPedidoparaEmail($iFolioPedido);
			include('../mail/email.php');
			include('../ajax/pedidos_send.php');
			$G_email = $vEmail;
			$tmp_tiempo = date("Y-m-d H:i:s");
			$tmp_token = sha1(md5($G_email ."". $tmp_tiempo));
			$to = $G_email;
			$from_email = "apps.bastidas@gmail.com";
			$from = "Diversiones Piscis<$from_email>"; 
			$subject = "Diversiones Piscis, pedido capturado exitosamente ".$tmp_tiempo; 
			$message = '';
			$message .= $html;
			
			$headers = "From: " . strip_tags($from_email) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$Respuesta = email($G_email,$subject,$message,"");
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 24){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = validarSiElPedidoEnviaHoy($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al revisar si el folio capturado se envia hoy mismo!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 25){
		if($vFechaMes != '' && $vFechaAnio != ''){
			$Respuesta = sumarDiasaFecha($vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al sumarle dias a la fecha!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 26){
		if($vFechaMes != '' && $vFechaAnio != ''){
			$Respuesta = ValidarSiLaFechaEsHoy($vFechaMes,$vFechaAnio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al comparar las fechas!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 27){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = RevertirFolioLiberado($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra liberado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 28){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = RevertirAbonoaFolio($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al revertir el abono!");
		}
		echo json_encode($Respuesta);
	}
	*/

	
	function ValidarInteger($entero){
		if ($entero <= 0){
			return false;
		}else{
			return true;
		}
	}
?>