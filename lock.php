<?PHP 
	include('calls/fn_generales.php');
	include('conx/conexiones.php');
	require_once("inc/init.php"); 

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		session_start();
		$arreglo = array("success"=>"false","data"=>"","error"=>"Verificar los datos de usuario");
		$sEmail = (ISSET($_POST['email'])?$_POST['email']:'');
		$sPassword = (ISSET($_POST['password'])?$_POST['password']:'');
		$respuesta = ValidaSesion($sEmail,$sPassword);
		if ($respuesta['keyx'] == null){
			session_destroy();
			$error=  "Usuario o contrase&ntilde;a incorrectas.";
			$arreglo['success'] = false;
			$arreglo['error'] = $error;
		}else{
			$sPermisos = $respuesta['permisos'];
			$_SESSION['id_puesto'] = $respuesta['id_puesto'];
			$_SESSION['permisos'] = $sPermisos;
			$_SESSION['keyx'] = $respuesta['keyx'];
			$_SESSION['nombreUsuario'] = $respuesta['nombre'];
			if (!ISSET($_SESSION['permisos']) || $sPermisos == null){
				session_destroy();
				$error=  "Usuario no tiene permisos para esta opción.";
				$arreglo['success'] = false;
				$arreglo['error'] = $error;
			}else{
				$arreglo['success'] = true;
				$arreglo['data'] = APP_URL;
				$arreglo['error'] = '';
			}
		}
		echo json_encode($arreglo);
	}
	
?>