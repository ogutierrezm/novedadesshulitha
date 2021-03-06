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
	
	if( $funcion == 1){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarUnPedidosPendiente($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarArticulosUnPedidosPendiente($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
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
	}

	
	
	function ValidarInteger($entero){
		if ($entero <= 0){
			return false;
		}else{
			return true;
		}
	}
?>