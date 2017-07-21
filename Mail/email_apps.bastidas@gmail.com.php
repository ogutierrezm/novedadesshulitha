<?php
	/*$G_email ='jbastidas86@gmail.com';
	$tmp_tiempo = date("Y-m-d H:i:s");
	$tmp_token = sha1(md5($G_email ."". $tmp_tiempo));
	$to = $G_email;
	$from_email = "apps.bastidas@gmail.com";
	$from = "Administracion e-Commerce <$from_email>"; 
	$subject = "Usted ha recibido un Token"; 
	$message = "<h1>Sistema e-Commerce</h1>";
	$message .= "<span style='font-size:22px;'>Inicie su sesion proporcionando el siguiente token:<br/><b>".$tmp_token."</b></span><br/><br/>";
	$message .= "<span style='font-size:18px;color:#000000;'><b>Nota:</b>&nbsp;<span style='color:#FE0000;'>La vigencia del token es de 5 minutos [$tmp_tiempo].</span></span>";
	$headers = "From: " . strip_tags($from_email) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$Resultado = email($G_email,$subject,$message,"");
	echo json_encode($Resultado);*/
	
	function email($email, $subject, $contenido, $cco){
		$Respuesta = array("codigo" => "","mensaje" => "");
		require('cnfg/class.phpmailer.php');
		//$contenido      = preg_replace('/\\\\/','', $contenido); //Strip backslashes
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
		$mail->IsSMTP();									// tell the class to use SMTP
		$mail->SMTPAuth   = true;
		$mail->SMTPDebug  = 0;								// enables SMTP debug information (for testing)
		$mail->SMTPSecure  = "ssl";								// enables SMTP debug information (for testing)
		$mail->Port       = 465;								// set the SMTP server port
		$mail->Host       = "smtp.gmail.com";					// SMTP server
		$mail->Username   = "apps.bastidas@gmail.com";			// SMTP server username
		$mail->Password   = "tj20031986";					// SMTP server password
		$mail->SetFrom('apps.bastidas@gmail.com', 'Diversiones Piscis');
		$mail->Timeout=30;
		$mail->AddAddress($email);
		$mail->Subject  = $subject;
		$mail->AltBody    = "Para ver el mensaje correctamente debe contar con un visor de correo que soporte codigo HTML"; // optional, comment out and test
		$mail->WordWrap   = 80; // set word wrap
		$mail->MsgHTML($contenido);
		$exito = $mail->Send();
		$intentos=1;

		
		while((!$exito) && ($intentos < 5)){
			sleep(5);
			$exito = $mail->Send();
			$intentos++;
		}
		
		if(!$exito){
			$Respuesta["codigo"] = $exito;
			$Respuesta["mensaje"] = $mail->ErrorInfo;
			return $Respuesta;
		}
		else{
			
			$Respuesta["codigo"] = $exito;
			$Respuesta["mensaje"] = "Correo enviado a ".$email;
			return $Respuesta;
		}
	}
?>
