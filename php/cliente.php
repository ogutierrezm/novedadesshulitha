<?php
	include ('../calls/fn_generales.php');
	include('../conx/conexiones.php');	
	include('../conx/constant.php');	
	
	$funcion = (ISSET($_POST['funcion'])?$_POST['funcion']:'') ;
	$telefonocelular = (ISSET($_POST['telefonocelular'])?$_POST['telefonocelular']:0) ;
	$telefonocasa = (ISSET($_POST['telefonocasa'])? $_POST['telefonocasa']:0);
	$cliente = (ISSET($_POST['cliente'])? $_POST['cliente']:0);
	$nombre = (ISSET($_POST['nombre'])? $_POST['nombre']:'');
	$apellido = (ISSET($_POST['apellido'])? $_POST['apellido']:'');
	$calle = (ISSET($_POST['calle'])? $_POST['calle']:'');
	$numext = (ISSET($_POST['numext'])? $_POST['numext']:0);
	$numint = (ISSET($_POST['numint'])? $_POST['numint']:0);
	$CodigoPostal = (ISSET($_POST['CodigoPostal'])? $_POST['CodigoPostal']:0);
	$Colonia = (ISSET($_POST['Colonia'])? $_POST['Colonia']:'');
	$municipio = (ISSET($_POST['municipio'])? $_POST['municipio']:'');
	$referencias = (ISSET($_POST['referencias'])? $_POST['referencias']:'');
	
	$iCantidad = (ISSET($_POST['cantidad'])? $_POST['cantidad']:0);
	$iId_articulo = (ISSET($_POST['id_articulo'])? $_POST['id_articulo']:0);
	$vHorarioRenta = (ISSET($_POST['horariorenta'])? $_POST['horariorenta']:'');

	$iFolioPedido = (ISSET($_POST['foliopedido'])? $_POST['foliopedido']:0);
	$iClientekeyx = (ISSET($_POST['clientekeyx'])? $_POST['clientekeyx']:'');
	$iDireccionpedidokeyx = (ISSET($_POST['direccionkeyx'])? $_POST['direccionkeyx']:'');
	$fechaentrega = (ISSET($_POST['fechaentrega'])? $_POST['fechaentrega']:'');
	$fecharecolecta = (ISSET($_POST['fecharecolecta'])? $_POST['fecharecolecta']:'');
	$fechavence = (ISSET($_POST['fechavence'])? $_POST['fechavence']:'');
	$empleado = (ISSET($_POST['empleado'])? $_POST['empleado']:0);
	$supervisor = (ISSET($_POST['supervisor'])? $_POST['supervisor']:0);
	$gerente = (ISSET($_POST['gerente'])? $_POST['gerente']:0);
	$iTipoPago = (ISSET($_POST['tipopago'])? $_POST['tipopago']:0);
	$iPlazo = (ISSET($_POST['plazo'])? $_POST['plazo']:0);
	$iPeriodoCobro = (ISSET($_POST['periodocobro'])? $_POST['periodocobro']:0);
	$bNumReferencias = (ISSET($_POST['numreferencias'])? $_POST['numreferencias']:0);
	$bNum_contrato = (ISSET($_POST['num_contrato'])? $_POST['num_contrato']:0);
	$bNum_papeleta = (ISSET($_POST['num_papeleta'])? $_POST['num_papeleta']:0);
	$bNum_descuento = (ISSET($_POST['num_descuento'])? $_POST['num_descuento']:0);
	
	
	
	$flag_especial = (ISSET($_POST['flag_especial'])? $_POST['flag_especial']:'');
	$hora2 = (ISSET($_POST['hora2'])? $_POST['hora2']:'');
	$hora1 = (ISSET($_POST['hora1'])? $_POST['hora1']:'');
	$mantel = (ISSET($_POST['mantel'])? $_POST['mantel']:'');
	$flete = (ISSET($_POST['flete'])? $_POST['flete']:0);
	$iIva = (ISSET($_POST['iva'])? $_POST['iva']:0);
	$iFlag_descuento = (ISSET($_POST['flag_descuento'])? $_POST['flag_descuento']:0);
	$iPorcentajedescuento = (ISSET($_POST['porcentajedescuento'])? $_POST['porcentajedescuento']:0);
	$iGarantia = (ISSET($_POST['garantia'])? $_POST['garantia']:0);
	$rfc = (ISSET($_POST['rfc'])? $_POST['rfc']:'');
	$razonsocial = (ISSET($_POST['razonsocial'])? $_POST['razonsocial']:'');
	$estado = (ISSET($_POST['estado'])? $_POST['estado']:'');
	$iFlag_descuentoautomatico = (ISSET($_POST['flag_descuentoautomatico'])? $_POST['flag_descuentoautomatico']:'');
	
	
	if( $funcion == 1){
		//print_r($telefonocelular);
		//print_r($telefonocasa);
		if(ValidarTelefonos($telefonocelular)){
			$Respuesta = consultaCtePorTelefono($telefonocelular);
			//print_r($Respuesta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		//print_r($telefonocelular);
		//print_r($telefonocasa);
		if(ValidarTelefonos($telefonocasa)){
			$Respuesta = consultaCtePorTelefono($telefonocasa);
			//print_r($Respuesta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
		if(ValidarTelefonos($cliente)){
			$Respuesta = consultarDomicilioPorCte($cliente);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		if(ValidarClienteNuevo($nombre,$apellido,$telefonocasa,$telefonocelular)){
			$Respuesta = pedidoGrabarCliente($nombre,$apellido,$telefonocasa,$telefonocelular);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 5){
		if(validarDomicilioNuevo($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias,$iClientekeyx)){
			$Respuesta = pedidoGrabarDomicilio($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias,$iClientekeyx);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 6){
		if(validarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta)){
			$esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
			$Respuesta = pedidoGrabarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta,$esRenta,$bNum_descuento);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 7){
		if (validarDatosPedidoNuevoMuebleria($iFolioPedido,$iClientekeyx,$iDireccionpedidokeyx,$bNumReferencias,$fechaentrega,$fecharecolecta,$fechavence,$iPlazo,$iPeriodoCobro,$iTipoPago,$empleado,$supervisor,$gerente))
		{
			$Respuesta = pedidoGrabarPedido($iFolioPedido,$iClientekeyx,$iDireccionpedidokeyx,$bNumReferencias,$fechaentrega,$fecharecolecta,$fechavence,$iPlazo,$iPeriodoCobro,$iTipoPago,$empleado,$supervisor,$gerente,$bNum_contrato,$bNum_papeleta,$bNum_descuento);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 8){
		if(validarDatosPedidoNuevo($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado)){
			$Respuesta = recibirArticulosPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 9){
		if(validarDatosPedidoNuevo($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado)){
			$Respuesta = modificarpedidoGrabarPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$mantel,$flete,$iIva,$iFlag_descuento,$iPorcentajedescuento,$iGarantia);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 10){		
		$Respuesta = modificarpedidoDetalleAnterior($iFolioPedido);
		echo json_encode($Respuesta);
	}else if( $funcion == 11){		
		$Respuesta = eliminarDomicilio($iClientekeyx,$iDireccionpedidokeyx);
		echo json_encode($Respuesta);
	}else if( $funcion == 12){
		if($iClientekeyx > 0){
			$Respuesta = consultaCtePorKeyx($iClientekeyx);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n o bien el usuario no se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 13){
		if(validarDatosFiscales($cliente,$razonsocial,$rfc,$calle,$numext,$numint,$Colonia,$CodigoPostal,$estado,$municipio)){
			$Respuesta = grabarDatosFiscales($cliente,$razonsocial,$rfc,$calle,$numext,$numint,$Colonia,$CodigoPostal,$estado,$municipio);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n o bien el usuario no se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 14){
		if($cliente > 0 && $iDireccionpedidokeyx > 0){
			$Respuesta = eliminarDatosFiscales($cliente,$iDireccionpedidokeyx);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n o bien el usuario no se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 15){
		if($cliente > 0 ){
			$Respuesta = aplicarDescuentoAutomatico($cliente,$iFlag_descuentoautomatico);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al consultar la informaci&oacute;n o bien el usuario no se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 16){
		$Respuesta = consultarClientesRFC();
		echo json_encode($Respuesta);
	}
	
	function validarDatosFiscales($cliente,$razonsocial,$rfc,$calle,$numext,$numint,$Colonia,$CodigoPostal,$estado,$municipio){
		if ($cliente <= 0){
			return false;
		}else if ($razonsocial == ''){
			return false;
		}else if ($rfc == ''){
			return false;
		}else if ($estado == ''){
			return false;
		}else if ($calle == ''){
			return false;
		}else if ($numext < 0){
			return false;
		}else if ($CodigoPostal == ''|| $CodigoPostal <= 0){
			return false;
		}else if ($Colonia == ''){
			return false;
		}else if ($municipio == ''){
			return false;
		}else{
			return true;
		}
	}
	
	
	function ValidarTelefonos($telefono){
		if ($telefono <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function ValidarClienteNuevo($nombre,$apellido,$telefonocasa,$telefonocelular){
		if ($telefonocelular <= 0 && $telefonocasa <= 0){
			return false;
		}else if ($nombre == ''){
			return false;
		}else  if ($apellido == ''){
			return false;
		}else{
			return true;
		}
	}
	
	function validarDomicilioNuevo($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias,$iClientekeyx){
		if ($calle == ''){
			return false;
		}else if ($numext < 0){
			return false;
		}else if ($CodigoPostal == ''|| $CodigoPostal <= 0){
			return false;
		}else if ($Colonia == ''){
			return false;
		}else if ($municipio == ''){
			return false;
		}else if ($iClientekeyx <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function validarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta){
		if ($iFolioPedido <= 0){
			return false;
		}else if ($iId_articulo <= 0){
			return false;
		}else if ($iCantidad <= 0){
			return false;
		}else{
			return true;
		}
	}
		
	function validarDatosPedidoNuevoMuebleria($iFolioPedido,$iClientekeyx,$iDireccionpedidokeyx,$bNumReferencias,$fechaentrega,$fecharecolecta,$fechavence,$iPlazo,$iPeriodoCobro,$iTipoPago,$empleado,$supervisor,$gerente)
	{
		if ($iFolioPedido <= 0){
			return false;
		}else if ($iClientekeyx <= 0){
			return false;
		}else if ($iDireccionpedidokeyx <= 0){
			return false;
		}else if ($bNumReferencias <= 0){
			return false;
		}else if ($fechaentrega == ''){
			return false;
		}else if ($fecharecolecta == ''){
			return false;
		}else if ($fechavence == ''){
			return false;
		}else if ($iPlazo <= 0){
			return false;
		}else if ($iPeriodoCobro <= 0){
			return false;
		}else if ($iTipoPago <= 0){
			return false;
		}else if ($empleado < 0){
			return false;
		}else if ($supervisor < 0){
			return false;
		}else if ($gerente <= 0){
			return false;
		}else{
			return true;
		}
	}
	
	function validarDatosPedidoNuevo($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2){		
		if ($iClientekeyx <= 0){
			return false;
		}else if ($iDireccionpedidokeyx <= 0){
			return false;
		}else if ($iFolioPedido <= 0){
			return false;
		}else if ($fechaentrega == ''){
			return false;
		}else if ($fecharecolecta == ''){
			return false;
		//}else if ($hora1 == ''){
		//	return false;
		//}else if ($flag_especial == 1 && $hora2 == ''){
		//	return false;
		}else{
			return true;
		}
	}
?>