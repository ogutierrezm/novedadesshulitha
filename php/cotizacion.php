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
	$iFolioPedido = (ISSET($_POST['foliopedido'])? $_POST['foliopedido']:0);
	$iId_articulo = (ISSET($_POST['id_articulo'])? $_POST['id_articulo']:0);
	$iCantidad = (ISSET($_POST['cantidad'])? $_POST['cantidad']:0);
	$vHorarioRenta = (ISSET($_POST['horariorenta'])? $_POST['horariorenta']:'');
	$iClientekeyx = (ISSET($_POST['clientekeyx'])? $_POST['clientekeyx']:'');
	$iDireccionpedidokeyx = (ISSET($_POST['direccionkeyx'])? $_POST['direccionkeyx']:'');
	$fechaentrega = (ISSET($_POST['fechaentrega'])? $_POST['fechaentrega']:'');
	$fecharecolecta = (ISSET($_POST['fecharecolecta'])? $_POST['fecharecolecta']:'');
	$flag_especial = (ISSET($_POST['flag_especial'])? $_POST['flag_especial']:'');
	$hora2 = (ISSET($_POST['hora2'])? $_POST['hora2']:'');
	$hora1 = (ISSET($_POST['hora1'])? $_POST['hora1']:'');
	$empleado = (ISSET($_POST['empleado'])? $_POST['empleado']:0);
	$mantel = (ISSET($_POST['mantel'])? $_POST['mantel']:'');
	$flete = (ISSET($_POST['flete'])? $_POST['flete']:0);
	$iIva = (ISSET($_POST['iva'])? $_POST['iva']:0);
	$iFlag_descuento = (ISSET($_POST['flag_descuento'])? $_POST['flag_descuento']:0);
	$iPorcentajedescuento = (ISSET($_POST['porcentajedescuento'])? $_POST['porcentajedescuento']:0);
	$iGarantia = (ISSET($_POST['garantia'])? $_POST['garantia']:0);
	$vEmail = (ISSET($_POST['email'])? $_POST['email']:'');
	
	if( $funcion == 1){
		if(ValidarClienteNuevo($nombre,$apellido,$telefonocasa,$telefonocelular)){
			$Respuesta = cotizacionGrabarCliente($nombre,$apellido,$telefonocasa,$telefonocelular);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el cliente ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 2){
		if(validarArticuloDePedidoNuevo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta)){
			$esRenta = (ARTICULORENTADO == 1)?ARTICULORENTADO:0;
			$Respuesta = cotizacionGrabarArticulo($iFolioPedido,$iId_articulo,$iCantidad,$vHorarioRenta,$esRenta);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 3){
		if(validarDatosCotizacion($iClientekeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado)){
			$Respuesta = cotizacionGrabarPedido($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$mantel,$flete,$iIva,$iFlag_descuento,$iPorcentajedescuento,$iGarantia);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 4){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = borrarCotizacion($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 5){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = '';
			$sResultado = consultarUnaCotizacionparaEmail($iFolioPedido);
			include('../mail/email.php');
			include('../ajax/cotizacion_send.php');
			$G_email = $vEmail;
			$tmp_tiempo = date("Y-m-d H:i:s");
			$tmp_token = sha1(md5($G_email ."". $tmp_tiempo));
			$to = $G_email;
			$from_email = "apps.bastidas@gmail.com";
			$from = "Diversiones Piscis<$from_email>"; 
			$subject = "Diversiones Piscis le cotiza ".$tmp_tiempo; 
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
	}else if( $funcion == 6){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = consultarUnaCotizacionparaEmail($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 7){		
		$Respuesta = modificarCotizacionDetalleAnterior($iFolioPedido);
		echo json_encode($Respuesta);
	}else if( $funcion == 8){
		if(validarDatosCotizacion($iClientekeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado)){
			$Respuesta = modificarCotizacionGrabarCotizacion($iClientekeyx,$iDireccionpedidokeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2,$empleado,$mantel,$flete,$iIva,$iFlag_descuento,$iPorcentajedescuento,$iGarantia);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o bien el usuario ya se encuentra registrado!");
		}
		echo json_encode($Respuesta);
	}else if( $funcion == 9){
		if(ValidarInteger($iFolioPedido)){
			$Respuesta = actualizaCotizacion($iFolioPedido);
		}else{
			$Respuesta = array("success"=>"false","data"=>"","error"=>"Ocurrio un error al grabar la informaci&oacute;n o el folio no se encuentra pendiente!");
		}
		echo json_encode($Respuesta);
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
	
	function validarDomicilioNuevo($calle,$numext,$numint,$CodigoPostal,$Colonia,$municipio,$referencias){
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
		}else if ($referencias == ''){
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
	
	function validarDatosCotizacion($iClientekeyx,$iFolioPedido,$fechaentrega,$fecharecolecta,$hora1,$flag_especial,$hora2){		
		if ($iClientekeyx <= 0){
			return false;
		}else if ($iFolioPedido <= 0){
			return false;
		}else if ($fechaentrega == ''){
			return false;
		}else if ($fecharecolecta == ''){
			return false;
		}else{
			return true;
		}
	}
	
	function ValidarInteger($entero){
		if ($entero <= 0){
			return false;
		}else{
			return true;
		}
	}
?>