<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//error_reporting(-1);
function getParameters($request){
	setLogData($request->getBody());
	$data = json_decode($request->getBody());
	$datos = arrayToObject(string_upper(objectToArray($data)));
	if(isset($datos->token)){
		$datos->token = strtolower($datos->token);
	}
	if(isset($datos->pwd)){
		$datos->pwd = strtolower($datos->pwd);
	}
	return $datos;
}

function setLogData($data_text){
	$data_text = NAME_OF_FUNCTION.'  -  '.$data_text.PHP_EOL;
	file_put_contents( FILE_LOG , $data_text , FILE_APPEND | LOCK_EX );
}

function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}

function arrayToObject($d) {
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return (object) array_map(__FUNCTION__, $d);
	}
	else {
		// Return object
		return $d;
	}
}

function ejecutarProcesosTda($sql){
	$response = array('data' => null, 'error' => '');
	$db = new wArLeY_DBMS(BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA);
	$dbObj = $db->Cnxn();
	if ($db->getError() == '') {
		$rs = $db->query($sql);
		if ($db->getError() != "") {
			$response['error'] = $db->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			$response['data'] =$rs_final[0];
		}
	} else {
		$response['error'] = $db->getError();
	}
	
	$db->disconnect();
	
	return $response;
}

function ejecutarProcesosABC($sql){
	$response = array('data' => null, 'error' => '');
	$db = new wArLeY_DBMS(DB_ABC_TYPE, DB_ABC_HOST, DB_ABC_DB, DB_ABC_USR, DB_ABC_PWD, DB_ABC_PORT);
	$dbObj = $db->Cnxn();
	if ($db->getError() == '') {
		$rs = $db->query($sql);
		if ($db->getError() != "") {
			$response['error'] = $db->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			$response['data'] =$rs_final[0];
		}
	} else {
		$response['error'] = $db->getError();
	}
	
	$db->disconnect();
	return $response;
}

function ejecutarProcesosMR($sql){
	$response = array('data' => null, 'error' => '');
	$db = new wArLeY_DBMS(BD_TYPE_MR, BD_HOST_MR, BD_MR, BD_USER_MR, BD_PASSWORD_MR, BD_PORT_MR);
	$dbObj = $db->Cnxn();
	if ($db->getError() == '') {
		$rs = $db->query($sql);
		if ($db->getError() != "") {
			$response['error'] = $db->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			$response['data'] =$rs_final[0];
		}
	} else {
		$response['error'] = $db->getError();
	}
	
	$db->disconnect();
	
	return $response;
}

function ejecutarProcesosCar($sql){
	$response = array('data' => null, 'error' => '');
	$db = new wArLeY_DBMS(DB_CARTERA_TYPE, DB_CARTERA_HOST, DB_CARTERA_DB, DB_CARTERA_USR, DB_CARTERA_PWD, DB_CARTERA_PORT);
	$dbObj = $db->Cnxn();
	if ($db->getError() == '') {
		$rs = $db->query($sql);
		if ($db->getError() != "") {
			$response['error'] = $db->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			//print_R($rs_final);
			$response['data'] =$rs_final;
		}
	} else {
		$response['error'] = $db->getError();
	}
	
	$db->disconnect();
	
	return $response;
}

function ejecutarProcesosABCiudades($sql){
	$response = array('data' => null, 'error' => '');
	$db = new wArLeY_DBMS(DB_ABC_TYPE, DB_ABC_HOST, DB_ABC_DB, DB_ABC_USR, DB_ABC_PWD, DB_ABC_PORT);
	$dbObj = $db->Cnxn();
	if ($db->getError() == '') {
		$rs = $db->query($sql);
		if ($db->getError() != "") {
			$response['error'] = $db->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			//print_R($rs_final);
			$response['data'] =$rs_final;
		}
	} else {
		$response['error'] = $db->getError();
	}
	
	$db->disconnect();
	
	return $response;
}

function consultarCorreoM( $cEmail, $iOrigen, $iSubOrigen, $iTienda, $iNumEmpleado, $iAreaTienda, $iNumCajaTienda ){
	$wsdl = WSCORREOS;
	$valorregreso = -1;
	try {
		$cliente = new SoapClient($wsdl);

		$param = array('email' => $cEmail,'clave_origen' => $iOrigen,'num_suborigen' => $iSubOrigen,'num_tiendaorigen' => $iTienda,'num_empleado' => 
		$iNumEmpleado,'num_areaempleado' => $iAreaTienda,'num_cajaempleado' => $iNumCajaTienda);

		//Antes de grabar el correo se verifica que no exista,
		$responsetipousuario = $cliente->__call('consultaPorCorreo',array($param));

		$responsetipousuario = objectToArray($responsetipousuario);
		$array = objectToArray ($responsetipousuario['return']);
		$array = json_decode ($array,true );
		$valorregreso = $array['ivalorretorno'];
	} catch (SoapFault $fault) {
		$valorregreso = -1;
	}
	return $valorregreso;
}

function creacion_token(){
	$caracteres_validos = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
	$token = "";
	for($i=1;$i<=10;$i++)
	{
		$numero_aleatorio = rand(0,33); 
		$token = $token.substr($caracteres_validos, $numero_aleatorio, 1);
	}
	return $token;
}

function grabarCorreoCliente($nombre,$ape_paterno,$ape_materno,$password, $cEmail ){
	$response = array('data' => 0, 'error' => '');
	$cToken = creacion_token();
	$cToken = md5( $cEmail.$cToken );
	$cNombre = "Contado";
	$pass = md5($password);
	$qGrabarCorreo = "SELECT fun_grabarregistrocliente('$nombre','$ape_paterno','$ape_materno','".$cEmail."','$pass',0,'".$cToken."') AS enviarcorreo;";
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}else{
		$resultadoConsulta = $conexionBDTiendaV->query( $qGrabarCorreo );
		if($resultadoConsulta == false){
			$response['error'] = $conexionBDTiendaV->getError();
		}
		//Se recorre la informacion de la consulta
		foreach($resultadoConsulta as $row){
			$resExiste = $row['enviarcorreo'];
		}
		if( $resExiste == 1 ){
			enviarCorreo( $cEmail, $cToken, $cNombre );
		}
		$response['data'] = $resExiste;
	}
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	return $response;
}

function enviarCorreo( $cEmail, $cToken, $cNombre )
{
	$opCor		= 3;
	$cNombre	= explode(" ",trim($cNombre));
	$cNombreCte	= urlencode( $cNombre[0] );
	$cApellido	= "Contado";
	$cApellido	= explode(" ",trim($cApellido));
	$cApellido	= urlencode($cApellido[0]);

	//$cDatos 	= "opcion=".$opCor."&correo=".$cEmail."&nombre=".$cNombreCte."&apellidopaterno=".$cApellido."&urlact=".$cToken;
	$data = array(
		'opcion'=>$opCor,
		'correo'=>$cEmail,
		//'correo'=>'ogutierrezm@coppel.com',
		'nombre'=>$cNombreCte,
		'apellidopaterno'=>$cApellido,
		'urlact'=>$cToken,
	);
	$respC 		= agrega_curl_get( $data );
}

function verificarcliente($cEmail){
	$response = array('data' => 0, 'error' => '');
	$cEmail = strtoupper ($cEmail);
	$contador = 0;
	$query = "select fn_consulta_cliente as contador from fn_consulta_cliente('$cEmail');";
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	$rs = $conexionBDTiendaV->query( $query );
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	if($rs == false){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	foreach($rs as $row){
		$contador = $row['contador'];
	}
	$response['data'] = $contador;
	return $response;
}

function validatoken($ctoken,$sIduproveedor){
	$response = array('data' => 0, 'error' => '');
	$contador = 0;
	$query = "SELECT * FROM fun_wifivalidatoken('".$ctoken."',".$sIduproveedor."::SMALLINT) AS retorno";
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	$rs = $conexionBDTiendaV->query( $query );
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	if($rs == false){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	foreach($rs as $row){
		$contador = $row['retorno'];
	}
	$response['data'] = $contador;
	return $response;
}

function obtenerCiudad($tienda){
	$response = array('data' => 0, 'error' => '');
	$contador = 0;
	$query = "SELECT cd.nombre AS nom_ciudad FROM sucursales AS suc INNER JOIN ciudades AS cd ON (cd.ciudad = suc.ciudad ) WHERE numerosucursal = ".$tienda.";";
	$conexionBDTiendaV = new wArLeY_DBMS( DB_ABC_TYPE, DB_ABC_HOST, DB_ABC_DB, DB_ABC_USR, DB_ABC_PWD, DB_ABC_PORT );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	$rs = $conexionBDTiendaV->query( $query );
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	if($rs == false){
		$response['error'] = $conexionBDTiendaV->getError();
	}
	foreach($rs as $row){
		$contador = $row['nom_ciudad'];
	}
	$response['data'] = $contador;
	return $response;
}


function registrarCliente($nombre,$ape_paterno,$ape_materno,$password,$cEmail){
	$response = array('data' => 0, 'error' => '');
	$return = 0;
	$sError = "";
	$iRespuesta = arrayToObject ( eliminarCorreoAnterior( $cEmail ) );
	$return = $iRespuesta->data;
	$sError =  $iRespuesta->error;
	if( in_array( $return , range( 1 , 2 ) )   ){
		$iRespuesta = arrayToObject( grabarCorreoCliente($nombre,$ape_paterno,$ape_materno,$password, $cEmail ) );
		$return = $iRespuesta->data;
		$sError =  $iRespuesta->error;
	}else{
		if($i==3){
			$return = 1;
		}else{
			$return = -1;
		}
	}
	$response['data'] = $return;
	$response['error'] = $sError;
	return $response;
}

function eliminarCorreoAnterior( $cEmail ){
	$response = array('data' => 0, 'error' => '');
	$qBorraCorreo = "SELECT fun_borrarpreregistrocliente('".$cEmail."') AS enviarcorreo;";
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}else{
		$resultadoConsulta = $conexionBDTiendaV->query( $qBorraCorreo );
		if($resultadoConsulta === false){
			$response['error'] = $conexionBDTiendaV->getError();
		}else{
			//Se recorre la informacion de la consulta
			$resExiste = 0;
			foreach($resultadoConsulta as $row){
				$resExiste = $row['enviarcorreo'];
			}
			$response['data'] = $resExiste;
		}
	}
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	return $response;
}

function grabarCatClientes($cNombre,$cApellidoPaterno,$cApellidoMaterno,$cEmail,$cPassword){
	$response = array('success'=>false,'data' => array(), 'error' => '');
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObj = $conexionBDTiendaV->Cnxn();
	if( $dbObj == false ){
		$response['error'] = $conexionBDTiendaV->getError();
	}else{
		$cPassword = md5($cPassword);
		$sql = "select fun_mrgrabarregistrocliente('$cNombre','$cApellidoPaterno','$cApellidoMaterno','$cEmail','$cPassword') as regreso";
		$rs = $conexionBDTiendaV->query($sql);
		if($rs === false){
				$response['error'] = $conexionBDTiendaV->getError();
		}else{
			$rs_final = objectToArray($rs->fetchAll(PDO::FETCH_OBJ));
			$resultadoMR = json_decode( $rs_final['regreso'] );
			if($resultadoMR->error == ''){
				$response['success'] =true;
			}else{
				$response['error'] = $resultadoMR->error;
			}
		}
	}
	
	$conexionBDTiendaV->disconnect();
	$conexionBDTiendaV = null;
	return $response;
}

function validacionstrikeiron($cEmail){
	$bRegresa = 0;
	try{
	$pagina = file_get_contents('http://www.coppel.com/enviomail/ValidaEmail.php?email='.strtolower( $cEmail));
	$pagina=   ( json_decode($pagina,true) );
		if ( $pagina['Estatus']==200 || $pagina['Estatus']==202 || $pagina['Estatus']==203 ){
			$bRegresa = 1;
		}

	} catch (Exception $e) {}
	return $bRegresa;
}

function grabarCorreo( $iNumCliente, $cEmail, $iOrigen, $iSubOrigen, $iTienda, $iNumEmpleado, $iAreaTienda, $iNumCajaTienda ){
	$wsdl = WSCORREOS;
	$valorregreso = -1;
	try {
		$cliente = new SoapClient($wsdl);

		$param = array('num_cliente' => $iNumCliente,'num_solicitante' => '0','email' => $cEmail,'flag_huella' => '0','clave_origen' => $iOrigen,'num_suborigen' => $iSubOrigen,
		'num_tiendaorigen' => $iTienda,'num_empleado' => $iNumEmpleado,'num_areaempleado' => $iAreaTienda,'num_cajaempleado' => $iNumCajaTienda, 'res_consulta' => '17');

		$responsetipousuario = $cliente->__call('grabarRegistroeCorreos',array($param));

		$arreglo_Retorno = (json_encode($responsetipousuario));
		$arreglo_Retorno = array($arreglo_Retorno);
		$arreglo_Retorno =(json_decode($arreglo_Retorno[0]));

		foreach( $arreglo_Retorno as $key => $value )
		{
			$array = json_decode($value);
			foreach( $array as $key1 => $value2 )
			{
				if($key1=='ivalorretorno')
				{
					$valorregreso=$value2;
				}
			}
		}
	} catch (SoapFault $fault) {
		$valorregreso = -1;
	}
	return $valorregreso;
}

function agrega_curl_get($data ){
			
	/* Update URL to container Query String of Paramaters */
    $url = 'http://migracion.coppel.com/enviomail/cliente_activacion.php?' . http_build_query($data);
    /* cURL Resource */
    $ch = curl_init();
    /* Set URL */
    curl_setopt($ch, CURLOPT_URL, $url);
    /* Tell cURL to return the output */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* Tell cURL NOT to return the headers */
    curl_setopt($ch, CURLOPT_HEADER, false);
    /* Execute cURL, Return Data */
    $data = curl_exec($ch);
    /* Check HTTP Code */
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    /* Close cURL Resource */
    curl_close($ch);
    /* 200 Response! */
    if ($status == 200) {
        /* Debug */
       // var_dump($data);
    } else {
        /* Debug */
		error_log("error: ".trim($data),0);
    }
	return $data;
}

function fn_validaCofete($numero_telefonico){
	$response = array('data' => 0, 'error' => '' );
	$numero=$numero_telefonico;
	$ladas_2_digitos=array (55,33,81);
	$serie = "";
	$lada = "";
	$numeracion = "";
	
	$db_cofetel = new wArLeY_DBMS(DB_COFETEL_TYPE, DB_COFETEL_HOST, DB_COFETEL_DB, DB_COFETEL_USR, DB_COFETEL_PWD, DB_COFETEL_PORT);
	$dbObjX = $db_cofetel->Cnxn();
	if($dbObjX==false){ 
		$response['error'] = $db_cofetel->getError();
	}else{
		$num_index=substr($numero, 0, 2);
		if(in_array($num_index,$ladas_2_digitos)){
			$num_complement = substr($numero, 2, 10);
		}else{
			$num_index = substr($numero, 0, 3);
			$num_complement = substr($numero, 3, 10);
		}
		if(in_array($num_index,$ladas_2_digitos) && (strlen(trim($num_complement))==8)){
			$lada = trim($num_index);
			$serie = substr(trim($num_complement),0,4);
			$numeracion = substr(trim($num_complement),4,4);
		}else if((strlen(trim(substr($numero, 0, 3)))==3) && (strlen(trim($num_complement))==7)){
			$lada = trim($num_index);
			$serie = substr(trim($num_complement),0,3);
			$numeracion = substr(trim($num_complement),3,4);
		}else{
			$response['error'] =  'No cumple las validaciones correspondientes.';
		}
		if($response['error'] =="" ){
			if($lada[0]=="0"){ 
				$response['error'] =  'No existe.';
			}else{
				$ejecutar="SELECT count(1) as cuenta FROM crCatNumerosCofetel WHERE nir = $lada AND serie=$serie AND $numeracion BETWEEN numinicial AND numfinal";
				$rs = $db_cofetel->query($ejecutar);
				if($rs==false){
					$response['error'] = $db_cofetel->getError();
				}else{
					$cuenta = 0;
					foreach($rs as $row){
						$cuenta = $row['cuenta'];
					}
					if($cuenta==0){
						$response['error'] =  'No existe.';
					}else{
						$response['data'] =  1;
					}
				}
				$rs = null;
			}
		}
	}
	$db_cofetel->disconnect();
	$dbObjX = null;
	return $response;
}

function string_upper($arr){
	$c =  MB_CASE_UPPER;
    foreach ($arr as $k => $v) {
        $ret[$k] = trim(mb_convert_case($v, $c, "UTF-8"));
    }
    return $ret;
}

/*Si no existe la funcion*/
function http_response_code_header($code = NULL,$error) {
	if ($code !== NULL) {
		switch ($code) {
			case 100: $text = 'Continue'; break;
			case 101: $text = 'Switching Protocols'; break;
			case 200: $text = 'OK'; break;
			case 201: $text = 'Created'; break;
			case 202: $text = 'Accepted'; break;
			case 203: $text = 'Non-Authoritative Information'; break;
			case 204: $text = 'No Content'; break;
			case 205: $text = 'Reset Content'; break;
			case 206: $text = 'Partial Content'; break;
			case 300: $text = 'Multiple Choices'; break;
			case 301: $text = 'Moved Permanently'; break;
			case 302: $text = 'Moved Temporarily'; break;
			case 303: $text = 'See Other'; break;
			case 304: $text = 'Not Modified'; break;
			case 305: $text = 'Use Proxy'; break;
			case 400: $text = 'Bad Request'; break;
			case 401: $text = 'Unauthorized'; break;
			case 402: $text = 'Payment Required'; break;
			case 403: $text = 'Forbidden'; break;
			case 404: $text = 'Not Found'; break;
			case 405: $text = 'Method Not Allowed'; break;
			case 406: $text = 'Not Acceptable'; break;
			case 407: $text = 'Proxy Authentication Required'; break;
			case 408: $text = 'Request Time-out'; break;
			case 409: $text = 'Conflict'; break;
			case 410: $text = 'Gone'; break;
			case 411: $text = 'Length Required'; break;
			case 412: $text = 'Precondition Failed'; break;
			case 413: $text = 'Request Entity Too Large'; break;
			case 414: $text = 'Request-URI Too Large'; break;
			case 415: $text = 'Unsupported Media Type'; break;
			case 500: $text = 'Internal Server Error'; break;
			case 501: $text = 'Not Implemented'; break;
			case 502: $text = 'Bad Gateway'; break;
			case 503: $text = 'Service Unavailable'; break;
			case 504: $text = 'Gateway Time-out'; break;
			case 505: $text = 'HTTP Version not supported'; break;
			default:
				exit('Unknown http status code "' . htmlentities($code) . '"');
			break;
		}
		$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		$GLOBALS['http_response_code'] = $code;
		if($code==404){
			 header('X-Error-Message:', true, 404);
			 $array = array('error'=>$error);
			 echo json_encode($array);
			die();
		}else{
			header('OK', true, 200);
		}
	} else {
		$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
	}
	return $code;
}
/*---------------------------*/
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function isJson($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

function substr_gral($string,$limit){
	$limit = $limit ;
	$string = substr($string,0,$limit);
	return $string;
}

function fn_registraclientewifi($data){
	$response = array('data' => 0, 'error' => '' );	
	$conexionBDTiendaV = new wArLeY_DBMS( BD_TYPE_TDA, BD_HOST_TDA, BD_TDA, BD_USER_TDA, BD_PASSWORD_TDA, BD_PORT_TDA );
	$dbObjX = $conexionBDTiendaV->Cnxn();
	if($dbObjX==false){ 
		$response['error'] = $conexionBDTiendaV->getError();
	}else{
		$ejecutar="SELECT * FROM fun_wifiagregacliente (". $data->idproveedor ."::SMALLINT,'".$data->email."','".$data->nombre."','".$data->ap_paterno."','".$data->ap_materno."',".$data->edad."::SMALLINT,'".$data->genero."','".$data->celular."','".$data->sms."',NOW()::TIMESTAMP,NOW()::TIMESTAMP,".$data->tienda.",'".$data->ciudad."') AS retorno;";
		$rs = $conexionBDTiendaV->query($ejecutar);
		if($rs==false){
			$response['error'] = $conexionBDTiendaV->getError();
		}else{
			$retorno = 0;
			foreach($rs as $row){
				$retorno = $row['retorno'];
			}
			if($retorno==0){
				$response['error'] =  'No se grabo el registro.';
			}else{
				$response['data'] =  $retorno;
			}
		}
		$rs = null;
	}
	$conexionBDTiendaV->disconnect();
	$dbObjX = null;
	return $response;
}
?>